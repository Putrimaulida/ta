<?php

namespace App\Http\Controllers;

use App\Models\CitraSatelit;
use App\Models\AnalisisData;
use App\Models\DataLapang;
use Illuminate\Http\Request;
use App\Models\Pantais;
use Yajra\DataTables\DataTables;

class HasilAnalisisController extends Controller
{
    /**
     * Menampilkan daftar jenis mangrove.
     *
     * @return \Illuminate\Http\Response
     */

    public function json()
    {
        $users = AnalisisData::select(['id', 'pantai_id'])
            ->with('pantai:id,nama_pantai') // Load relasi pantai
            ->get();
        $index = 1;
        return DataTables::of($users)
            ->addColumn('DT_RowIndex', function ($data) use (&$index) {
                return $index++; // Menambahkan nomor urutan baris
            })
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataRekomendasiPantai = Pantais::all();
        $allYears = CitraSatelit::select('tahun')->distinct()->pluck('tahun');

        return view('admin.analisis.index', compact('dataRekomendasiPantai', 'allYears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.analisis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pantai_id' => 'required',
        ]);

        AnalisisData::create($request->all());

        return redirect()->route('admin.analisis')
            ->with('success', 'Rekomendasi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekomendasi  $rekomendasi
     * @return \Illuminate\Http\Response
     */
    public function show(AnalisisData $analisis)
    {
        return view('analisis.show', compact('analisis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rekomendasi  $rekomendasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataAnalisis = AnalisisData::findOrFail($id);
        $dataPantai = Pantais::pluck('nama_pantai', 'id'); // Mengambil daftar pantai untuk dropdown

        return view('admin.analisis.index', compact('dataPantai', 'dataAnalisis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rekomendasi  $rekomendasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnalisisData $rekomendasi)
    {
        $request->validate([
            'pantai_id' => 'required',
        ]);

        $rekomendasi->update($request->all());

        return redirect()->route('analisis.index')
            ->with('success', 'Analisis data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rekomendasi  $rekomendasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnalisisData $analisis)
    {
        $analisis->delete();

        return redirect()->route('analisis.index')
            ->with('success', 'Rekomendasi deleted successfully');
    }

    public function countRecommended(Request $request)
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