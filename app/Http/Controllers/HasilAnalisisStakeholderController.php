<?php

namespace App\Http\Controllers;

use App\Models\CitraSatelit;
use App\Models\AnalisisData;
use Illuminate\Http\Request;
use App\Models\Pantais;
use Yajra\DataTables\DataTables;

class HasilAnalisisStakeholderController extends Controller
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
        return view('stakeholder.analisis.index', compact('dataRekomendasiPantai'));
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

        return redirect()->route('stakeholder.analisis')
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

        return view('stakeholder.analisis.index', compact('dataPantai', 'dataAnalisis'));
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

    public function countRecommendedStakeholder(Request $request)
    {
        if ($request->pantai_id == 'all') {
        }
        $dataCitra = CitraSatelit::where('pantai_id', $request->pantai_id)->get();
        $dataTahun = CitraSatelit::where('pantai_id', $request->pantai_id)->pluck('tahun')->unique();
        $tahunArray = $dataTahun->toArray();
        sort($tahunArray);

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

        foreach ($dataCitra as $data) {
            $sum_x += $data->tahun;
            $sum_y += $data->luasan;
            $sum_xy += $data->tahun * $data->luasan;
            $sum_x_squared += $data->tahun * $data->tahun;
        }

        $n = count($dataCitra);
        $b = (($n * $sum_xy) - ($sum_x * $sum_y)) / (($n * $sum_x_squared) - ($sum_x * $sum_x));
        $a = ($sum_y - ($b * $sum_x)) / $n;
        $Y = $a + ($b * $dataCitra->max('tahun'));
        $countYear = count($dataCitra);
        $result = $Y + $b * $countYear;

        $resultFor2024 = [$dataCitra->max('tahun') + 1 => $result];
        $lastYear = $dataCitra->max('tahun');
        $lastYearArea = $luasanTahun[$lastYear];
        $trendConclusion = ($result < $lastYearArea) ? 'negatif' : 'positif';
        $year = date('Y');
        $conclusion = "Hasil analisis menunjukkan luasan mangrove pada tahun $year adalah <strong>$result</strong>. Dengan kondisi mangrove mengalami trend <strong>$trendConclusion</strong>.";

        return response()->json([
            'success' => true,
            'data' => [
                'pantai' => $dataCitra->first()->pantai->nama_pantai,
                'luasan_tiap_tahun' => $luasanTahun,
                'result' => $resultFor2024,
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'conclusion' => $conclusion
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

    public function countAllRecommendedStakeholder()
    {
        $dataCitra = CitraSatelit::all();

        $groupedData = $dataCitra->groupBy('pantai_id');
        $result = [];

        foreach ($groupedData as $pantaiId => $dataPantai) {
            $sum_x = 0;
            $sum_y = 0;
            $sum_xy = 0;
            $sum_x_squared = 0;

            foreach ($dataPantai as $data) {
                $sum_x += $data->tahun;
                $sum_y += $data->luasan;
                $sum_xy += $data->tahun * $data->luasan;
                $sum_x_squared += $data->tahun * $data->tahun;
            }

            $n = count($dataPantai);
            $b = (($n * $sum_xy) - ($sum_x * $sum_y)) / (($n * $sum_x_squared) - ($sum_x * $sum_x));
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
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
