<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Counts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table note
        $penjualan = Penjualan::all();

        //make response JSON
        return response()->json($penjualan, 200);

    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'marketing_id' => 'required',
            'bulan'        => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $penjualan = Penjualan::select('marketings.name', DB::raw('SUM(penjualans.grand_total) as total'), 'penjualans.date')
        ->join('marketings', 'penjualans.marketing_id', '=', 'marketings.id')
        ->whereMonth('date', $request->bulan)
        ->where('marketing_id', $request->marketing_id)->groupBy('marketing_id')->get();

        $dataSet = [];
        $total = 0;
        foreach ($penjualan as $item) {
            $total += $item->total;
            $dataSet= [
                'marketing_name'  => $item->name,
                'month'           => date('M', strtotime($item->date)),
                'total'           => (int)$item->total
            ];
        }

        switch ($total){
            case ((int)$total >= 0 && (int)$total <= 100000000): 
                $dataSet['persentage'] = 0;
                $dataSet['nominal_persentage'] = 0;
            break;
            case ((int)$total >= 100000000 && (int) $total <= 200000000): 
                $dataSet['persentage'] = 2.5;
                $totalPersen =  (int)$total * 2.5 / 100;
                $dataSet['nominal_persentage'] = $totalPersen;
            break;

            case ((int)$total >= 200000000 && (int) $total <= 500000000): 
                $dataSet['persentage'] = 5;
                $totalPersen =  (int)$total * 5 / 100;
                $dataSet['nominal_persentage'] = $totalPersen;
            break;
            default: //default
                $dataSet['persentage'] = 10;
                $totalPersen =  (int)$total * 10 / 100;
                $dataSet['nominal_persentage'] = $totalPersen;
            break;
         }

        $counts = Counts::insert($dataSet);
         

        //success save to database
        if($counts) {

            return response()->json([
                'success' => true,
                'message' => 'Counts Created',
                'data'    => $counts  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Counts Failed to Save',
        ], 409);

    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function savePerhitungan(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'marketing_id' => 'required',
            'bulan'        => 'required',
            'bunga'        => 'required',
            'jangka'        => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $penjualan = Penjualan::select('marketings.name', DB::raw('SUM(penjualans.grand_total) as total'), 'penjualans.date')
        ->join('marketings', 'penjualans.marketing_id', '=', 'marketings.id')
        ->whereMonth('date', $request->bulan)
        ->where('marketing_id', $request->marketing_id)->groupBy('marketing_id')->get();

        $angsuran = [];
        if(count($penjualan) > 0) {
            
            $sukuBunga = $request->bunga / 100;
            $pokok = (int)$penjualan[0]['total'] / $request->jangka;
            $bunga = (int)$penjualan[0]['total'] * $sukuBunga / $request->jangka;
            $sisaPinjaman = (int)$penjualan[0]['total'];
            $jumlahAngsuran = $pokok + $bunga;

            for($i = 0; $i < $request->jangka; $i++) {
                $sisaPinjaman -= $pokok;
                array_push($angsuran, [
                    "no"                => $i + 1,
                    "pokok"             => number_format(round($pokok), 0),
                    "bunga"             => number_format(round($bunga), 0),
                    "jumlahAngsuran"    => number_format(round($jumlahAngsuran), 0),
                    "sisaPinjaman"      => number_format(round($sisaPinjaman), 0)
                ]);
            }

        }
        return response()->json([
            'success' => true,
            'message' => 'Perhitungan Created',
            'data'    => $angsuran 
        ], 201);

    }

}
