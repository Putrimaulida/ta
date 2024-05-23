<?php

namespace App\Http\Controllers;

use App\Models\CitraSatelit;
use App\Models\DataLapang;
use App\Models\JenisMangrove;
use App\Models\Pantais;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function indexBeranda(){
        $dataPantai = Pantais::all();
        $dataMangrove = JenisMangrove::all();
        $dataRekomendasiPantai = Pantais::all();
        $allYears = CitraSatelit::select('tahun')->distinct()->pluck('tahun');
        return view('landingpage.beranda', compact('dataPantai', 'dataMangrove', 'dataRekomendasiPantai', 'allYears'));
    }
    public function countRecommendedBeranda(Request $request)
    {
        if ($request->pantai_id == 'all') {
            if ($request->tahun == 'all') {
                $dataCitra = CitraSatelit::all();
            } else {
                $dataCitra = CitraSatelit::where('tahun', $request->tahun)->get();
            }

            $groupedData = $dataCitra->groupBy('pantai_id');
            $result = [];

            foreach ($groupedData as $pantaiId => $dataPantai) {
                $sum_x = 0;
                $sum_y = 0;
                $sum_xy = 0;
                $sum_x_squared = 0;
                $index = 0;

                foreach ($dataPantai as $data) {
                    $sum_x += $index;
                    $sum_y += $data->luasan;
                    $sum_xy += $data->tahun * $data->luasan;
                    $sum_x_squared += $data->tahun * $data->tahun;
                    $index++;
                }

                $n = count($dataPantai);
                if ($n != 0) {
                    $denominator = ($n * $sum_x_squared) - ($sum_x * $sum_x);
                    if ($denominator != 0) {
                        $b = (($n * $sum_xy) - ($sum_x * $sum_y)) / $denominator;
                    } else {
                        $b = 0;
                    }
                } else {
                    $b = 0;
                }
                $a = ($sum_y - ($b * $sum_x)) / $n;
                $Y = $a + ($b * $dataPantai->max('tahun'));
                $countYear = count($dataPantai);
                $resultForYear = $Y + $b * $countYear;

                $resultFor2024 = [$dataPantai->max('tahun') + 1 => $resultForYear];
                $luasanTahun = $dataPantai->groupBy('tahun')->map(function ($item) {
                    return $item->sum('luasan');
                });
                $borderColor = $this->generateRandomColor();

                $result[] = [
                    'pantai' => $dataPantai->first()->pantai->nama_pantai,
                    'luasan_tiap_tahun' => $luasanTahun->toArray(),
                    'result' => $resultFor2024,
                    'borderColor' => $borderColor,
                    'sum_y' => $sum_y,
                    'sum_x' => $sum_x,
                    'a' => $a,
                    'b' => $b,
                    'n' => $n,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        }

        if ($request->tahun == 'all') {
            $dataCitra = CitraSatelit::where('pantai_id', $request->pantai_id)->get();
            $dataTahun = CitraSatelit::where('pantai_id', $request->pantai_id)->pluck('tahun')->unique();
            $tahunArray = $dataTahun->toArray();
            sort($tahunArray);

            // Data Lapang
            $dataLapang = DataLapang::where('pantai_id', $request->pantai_id)->get();
            $dataTahunLapang = DataLapang::where('pantai_id', $request->pantai_id)->pluck('tahun')->unique();
            $tahunArrayLapang = $dataTahunLapang->toArray();
            sort($tahunArrayLapang);

            $luasanLapang = [];
            foreach ($tahunArrayLapang as $tahun) {
                $dataTahunIni = $dataLapang->where('tahun', $tahun)->first();
                if ($dataTahunIni) {
                    $luasanLapang[$tahun] = $dataTahunIni->luasan;
                } else {
                    $luasanLapang[$tahun] = null;
                }
            }
        } else {
            $dataCitra = CitraSatelit::where('pantai_id', $request->pantai_id)->where('tahun', $request->tahun)->get();
            $tahunArray = [$request->tahun];
            $luasanLapang = null;
        }

        $luasanTahun = [];
        foreach ($tahunArray as $tahun) {
            $dataTahunIni = $dataCitra->where('tahun', $tahun)->first();
            if ($dataTahunIni) {
                $luasanTahun[$tahun] = $dataTahunIni->luasan;
            } else {
                $luasanTahun[$tahun] = null;
            }
        }

        $sum_x = 0;
        $sum_y = 0;
        $sum_xy = 0;
        $sum_x_squared = 0;
        $index = 0;

        foreach ($dataCitra as $data) {
            $sum_x += $index;
            $sum_y += $data->luasan;
            $sum_xy += $index * $data->luasan;
            $sum_x_squared += $index * $index;
            $index++;
        }

        $n = count($dataCitra);
        // $b = (($n * $sum_xy) - ($sum_x * $sum_y)) / (($n * $sum_x_squared) - ($sum_x * $sum_x)); // Rumus Lama
        if ($n != 0) {
            $denominator = ($n * $sum_x_squared) - ($sum_x * $sum_x);
            if ($denominator != 0) {
                $b = (($n * $sum_xy) - ($sum_x * $sum_y)) / $denominator;
            } else {
                $b = 0;
            }
        } else {
            $b = 0;
        }
        $a = ($sum_y - ($b * $sum_x)) / $n;
        // $Y = $a + ($b * $dataCitra->max('tahun'));
        // $countYear = count($dataCitra);
        $result = $a + ($b * $index);

        $resultFor2024 = [$dataCitra->max('tahun') + 1 => $result];
        $lastYear = $dataCitra->max('tahun');
        $lastYearArea = $luasanTahun[$lastYear];
        $trendConclusion = ($result < $lastYearArea) ? 'negatif' : 'positif';
        $year = date('Y');
        //$conclusion = "Hasil analisis menunjukkan luasan mangrove pada tahun <strong>$year</strong> adalah <strong>$result</strong>. Dengan kondisi mangrove mengalami trend <strong>$trendConclusion</strong>.";
        $conclusion = "Hasil analisis menunjukkan luasan mangrove pada tahun <strong>$year</strong> adalah <strong>$result</strong> dengan nilai <strong>a = $a</strong> dan <strong>b = $b</strong> serta <strong>n = $n</strong>, <strong> sum_y = $sum_y</strong>, <strong> sum_x = $sum_x</strong>, <strong> sum_xy = $sum_xy</strong>, <strong> sum_x_squared = $sum_x_squared</strong>. Dengan kondisi mangrove mengalami trend <strong>$trendConclusion</strong>.";

        return response()->json([
            'success' => true,
            'data' => [
                'pantai' => $dataCitra->first()->pantai->nama_pantai,
                'luasan_tiap_tahun' => $luasanTahun,
                'result' => $resultFor2024,
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'conclusion' => $conclusion,
                'data_lapang' => $luasanLapang
            ]
        ]);
    }
    private function generateRandomColor()
    {
        $r = mt_rand(0, 255);
        $g = mt_rand(0, 255);
        $b = mt_rand(0, 255);
        $alpha = 1;

        return "rgba($r, $g, $b, $alpha)";
    }
}
