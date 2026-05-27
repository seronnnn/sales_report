<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        $rows = $request->input('transactions', []);

        if (empty($rows)) {
            return response()->json(['success' => false, 'message' => 'No data received.'], 422);
        }

        $clean = function (?string $val): ?string {
            if ($val === null) return null;
            $v = trim($val);
            if ($v === '' || $v === '#' || strtolower($v) === 'not assigned') return null;
            return $v;
        };

        $normalizeKey = function($key) {
            $key = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower(trim($key)));
            return trim(preg_replace('/_+/', '_', $key), '_');
        };

        $lastId    = DB::table('sales_report')->max('id') ?? 0;
        $currentId = (int) $lastId;
        $chunks    = array_chunk($rows, 500);
        $inserted  = 0;

        DB::beginTransaction();
        try {
            foreach ($chunks as $chunk) {
                $mapped = array_map(function ($r) use ($clean, $normalizeKey, &$currentId) {
                    $normalizedRow = [];
                    foreach ($r as $key => $val) {
                        $normalizedRow[$normalizeKey($key)] = $val;
                    }
                    $get = function($k) use ($normalizedRow) {
                        return $normalizedRow[$k] ?? null;
                    };
                    $currentId++;
                    return [
                        'id'               => $currentId,
                        'business_area'    => $clean($get('business_area')),
                        'dc'               => $clean($get('dc')),
                        'division'         => $clean($get('division')),
                        'sales_doc_type'   => $clean($get('sales_doc_type')),
                        'month_num'        => $get('02_month'),
                        'month'            => $clean($get('month')),
                        'year'             => $get('year'),
                        'salesman_id'      => $clean($get('salesman_id')),
                        'salesman'         => $clean($get('salesman')),
                        'customer_id'      => $clean($get('customer_id')),
                        'customer'         => $clean($get('customer')),
                        'material_id'      => $clean($get('material_id')),
                        'material'         => $clean($get('material')),
                        'qty'              => (float) ($get('qty') ?? 0),
                        'gross_revenue'    => (float) ($get('gross_revenue') ?? 0),
                        'logistic_expense' => (float) ($get('logistic_expense') ?? 0),
                        'net_revenue'      => (float) ($get('net_revenue') ?? 0),
                        'cogs'             => (float) ($get('cogs') ?? 0),
                        'gross_gp'         => (float) ($get('gross_gp') ?? 0),
                        'gross_gm_percent' => (float) ($get('gross_gm_percent') ?? 0),
                    ];
                }, $chunk);

                DB::table('sales_report')->insert($mapped);
                $inserted += count($mapped);
            }

            DB::commit();
            return response()->json(['success' => true, 'inserted' => $inserted]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getReportData(Request $request)
    {
        try {
            $data = DB::table('sales_report')
                ->select('*')
                ->orderBy('business_area')
                ->orderBy('customer')
                ->get();

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Master Material
     * Returns one row per unique material_id with:
     * - material_id
     * - material (description)
     * - product_family  (derived from DC)
     * - subclass_1      (DC value, e.g. "DC 2")
     * - subclass_2      (Division field)
     *
     * GET /sales/master-material
     */
    public function getMasterMaterial(Request $request)
    {
        try {
            $dcFamilyMap = [
                '2'  => 'PAPER CHEMICAL',
                '02' => 'PAPER CHEMICAL',
                '4'  => 'PLASTIC, RUBBER',
                '04' => 'PLASTIC, RUBBER',
                '6'  => 'TEXTILE',
                '06' => 'TEXTILE',
                '8'  => 'PERSONAL & HOME CARE',
                '08' => 'PERSONAL & HOME CARE',
                '12' => 'OIL FIELD, MINING',
            ];

            $rows = DB::table('sales_report')
                ->select('material_id', 'material', 'dc', 'division')
                ->whereNotNull('material_id')
                ->where('material_id', '!=', '')
                ->groupBy('material_id', 'material', 'dc', 'division')
                ->orderBy('material_id')
                ->get();

            $seen   = [];
            $result = [];
            foreach ($rows as $r) {
                $mid = trim($r->material_id ?? '');
                if ($mid === '' || isset($seen[$mid])) continue;
                $seen[$mid] = true;

                $dcRaw  = trim($r->dc ?? '');
                $dcNum  = preg_replace('/^DC\s*/i', '', $dcRaw);
                $family = $dcFamilyMap[$dcNum] ?? ($dcFamilyMap[$dcRaw] ?? 'OTHERS');

                $result[] = [
                    'material_id'    => $mid,
                    'material'       => $r->material ?? '—',
                    'product_family' => $family,
                    'subclass_1'     => $dcRaw ?: '—',
                    'subclass_2'     => trim($r->division ?? '') ?: '—',
                ];
            }

            return response()->json([
                'success' => true,
                'total'   => count($result),
                'data'    => $result,
            ]);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a new Master Material entry.
     * Inserts a single placeholder row into sales_report so the material
     * appears in the master list immediately.
     *
     * POST /master/material/store
     * Body: { material_id, material }
     */
    public function storeMaterial(Request $request)
    {
        try {
            $data = $request->validate([
                'material_id' => 'required|string|max:100',
                'material'    => 'required|string|max:255',
            ]);

            // Prevent duplicate material_id
            $exists = DB::table('sales_report')
                ->where('material_id', trim($data['material_id']))
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Material ID already exists.',
                ], 422);
            }

            $newId = (DB::table('sales_report')->max('id') ?? 0) + 1;

            DB::table('sales_report')->insert([
                'material_id'      => trim($data['material_id']),
                'material'         => trim($data['material']),
            ]);

            return response()->json(['success' => true, 'message' => 'Material added successfully.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => implode(' ', $e->errors()[array_key_first($e->errors())])], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing Master Material entry.
     * Updates material description for ALL rows that share the given 
     * material_id so the change is consistent across all transaction records.
     *
     * PUT /master/material/{id}
     * Body: { material }
     */
    public function updateMaterial(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'material' => 'required|string|max:255',
            ]);

            $affected = DB::table('sales_report')
                ->where('material_id', $id)
                ->update([
                    'material'   => trim($data['material']),
                ]);

            if ($affected === 0) {
                return response()->json(['success' => false, 'message' => 'Material ID not found.'], 404);
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Material updated successfully.',
                'affected' => $affected,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => implode(' ', $e->errors()[array_key_first($e->errors())])], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Master Salesman
     * Returns aggregated rows per (salesman_id, salesman, customer, material) with:
     * - salesman_id
     * - salesman
     * - customer
     * - material
     * - total_qty
     * - total_gross_revenue
     * - total_net_revenue
     * - total_logistic_expense
     * - total_cogs
     * - total_gross_gp
     * - gross_gm_percent  (computed: total_gross_gp / total_gross_revenue * 100)
     *
     * GET /sales/master-salesman
     */
    public function getMasterSalesman(Request $request)
{
    try {
        // Step 1: get all raw rows per salesman (not grouped by customer/material)
        $rawRows = DB::table('sales_report')
            ->select(
                'salesman_id', 'salesman', 'customer', 'material',
                'qty', 'gross_revenue', 'net_revenue',
                'logistic_expense', 'cogs', 'gross_gp', 'month_num'
            )
            ->whereNotNull('salesman_id')
            ->where('salesman_id', '!=', '')
            ->orderBy('salesman_id')
            ->get();

        // Step 2: group by salesman_id, aggregate totals, collect detail rows
        $grouped = [];
        foreach ($rawRows as $r) {
            $sid = $r->salesman_id;
            if (!isset($grouped[$sid])) {
                $grouped[$sid] = [
                    'salesman_id'      => $sid,
                    'salesman'         => $r->salesman ?? '—',
                    'qty'              => 0,
                    'gross_revenue'    => 0,
                    'net_revenue'      => 0,
                    'logistic_expense' => 0,
                    'cogs'             => 0,
                    'gross_gp'         => 0,
                    'rows'             => [],
                ];
            }
            $grouped[$sid]['qty']              += (float)($r->qty ?? 0);
            $grouped[$sid]['gross_revenue']    += (float)($r->gross_revenue ?? 0);
            $grouped[$sid]['net_revenue']      += (float)($r->net_revenue ?? 0);
            $grouped[$sid]['logistic_expense'] += (float)($r->logistic_expense ?? 0);
            $grouped[$sid]['cogs']             += (float)($r->cogs ?? 0);
            $grouped[$sid]['gross_gp']         += (float)($r->gross_gp ?? 0);
            $grouped[$sid]['rows'][]            = [
                'customer'      => $r->customer,
                'material'      => $r->material,
                'qty'           => (float)($r->qty ?? 0),
                'gross_revenue' => (float)($r->gross_revenue ?? 0),
                'net_revenue'   => (float)($r->net_revenue ?? 0),
                'cogs'          => (float)($r->cogs ?? 0),
                'gross_gp'      => (float)($r->gross_gp ?? 0),
                'month_num'     => $r->month_num,
            ];
        }

        $result = array_values(array_map(function ($s) {
            $rev = $s['gross_revenue'];
            $gp  = $s['gross_gp'];
            $s['gross_gm_percent'] = $rev > 0 ? round($gp / $rev * 100, 4) : 0;
            return $s;
        }, $grouped));

        return response()->json(['success' => true, 'total' => count($result), 'data' => $result]);

    } catch (\Throwable $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    /**
     * Store a new Master Salesman entry.
     * Inserts a single placeholder row into sales_report so the salesman
     * appears in the master list immediately.
     *
     * POST /master/salesman/store
     * Body: { salesman_id, salesman }
     */
    public function storeSalesman(Request $request)
    {
        try {
            $data = $request->validate([
                'salesman_id' => 'required|string|max:100',
                'salesman'    => 'required|string|max:255',
            ]);

            // Prevent duplicate salesman_id
            $exists = DB::table('sales_report')
                ->where('salesman_id', trim($data['salesman_id']))
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Salesman ID already exists.',
                ], 422);
            }

            $newId = (DB::table('sales_report')->max('id') ?? 0) + 1;

            DB::table('sales_report')->insert([
                'id'               => $newId,
                'salesman_id'      => trim($data['salesman_id']),
                'salesman'         => trim($data['salesman']),
                // All financial fields default to 0 for a placeholder row
                'qty'              => 0,
                'gross_revenue'    => 0,
                'logistic_expense' => 0,
                'net_revenue'      => 0,
                'cogs'             => 0,
                'gross_gp'         => 0,
                'gross_gm_percent' => 0,
            ]);

            return response()->json(['success' => true, 'message' => 'Salesman added successfully.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => implode(' ', $e->errors()[array_key_first($e->errors())])], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing Master Salesman entry.
     * Updates the salesman name for ALL rows that share the given salesman_id
     * so the change is consistent across all transaction records.
     *
     * PUT /master/salesman/{id}
     * Body: { salesman }
     */
    public function updateSalesman(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'salesman' => 'required|string|max:255',
            ]);

            $affected = DB::table('sales_report')
                ->where('salesman_id', $id)
                ->update([
                    'salesman'   => trim($data['salesman']),
                ]);

            if ($affected === 0) {
                return response()->json(['success' => false, 'message' => 'Salesman ID not found.'], 404);
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Salesman updated successfully.',
                'affected' => $affected,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => implode(' ', $e->errors()[array_key_first($e->errors())])], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}