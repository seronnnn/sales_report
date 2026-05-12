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

        // FUNGSI PENTING: Untuk membersihkan nama kolom dari spasi dan karakter aneh
        $normalizeKey = function($key) {
            // Mengubah "   Qty" menjadi "qty", "02. Month" menjadi "02_month"
            $key = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower(trim($key)));
            return trim(preg_replace('/_+/', '_', $key), '_');
        };

        // Ambil ID terakhir dari tabel, jika kosong mulai dari 0
        $lastId = DB::table('sales_report')->max('id') ?? 0;
        $currentId = (int) $lastId;

        $chunks = array_chunk($rows, 500);
        $inserted = 0;

        DB::beginTransaction();
        try {
            foreach ($chunks as $chunk) {
                $mapped = array_map(function ($r) use ($clean, $normalizeKey, &$currentId) {

                    // Normalisasi semua key di baris ini
                    $normalizedRow = [];
                    foreach ($r as $key => $val) {
                        $normalizedRow[$normalizeKey($key)] = $val;
                    }

                    // Helper untuk ambil data dari key yang sudah bersih
                    $get = function($k) use ($normalizedRow) {
                        return $normalizedRow[$k] ?? null;
                    };

                    $currentId++; // Increment ID manual

                    return [
                        'id'               => $currentId,
                        'business_area'    => $clean($get('business_area')),
                        'dc'               => $clean($get('dc')),
                        'division'         => $clean($get('division')),
                        'sales_doc_type'   => $clean($get('sales_doc_type')),
                        'month_num'        => $get('02_month'), // Sesuai header "02. Month"
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
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getReportData(Request $request)
    {
        try {
            $data = DB::table('sales_report')
                ->select([
                    'business_area',
                    'dc',
                    'division',
                    'customer',
                    'material',
                    'qty',
                    'gross_revenue',
                    'gross_gp',
                ])
                ->orderBy('business_area')
                ->orderBy('customer')
                ->get();
    
            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
    
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}