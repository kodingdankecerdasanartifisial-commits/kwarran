<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $statistics = \App\Models\Statistic::orderBy('created_at', 'desc')->get();
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        $chartData = session('chartData');
        return view('admin.statistics.create', compact('chartData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'chart_data' => 'required'
        ]);

        \App\Models\Statistic::create([
            'title' => $request->title,
            'description' => $request->description,
            'chart_data' => json_decode($request->chart_data, true),
            'is_published' => true
        ]);

        session()->forget('chartData');
        return redirect()->route('admin.statistics.index')->with('success', 'Statistik berhasil dibuat.');
    }

    public function edit(\App\Models\Statistic $statistic)
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, \App\Models\Statistic $statistic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->has('is_published')
        ];

        if ($request->has('chart_data')) {
            $data['chart_data'] = json_decode($request->chart_data, true);
        }

        $statistic->update($data);

        return redirect()->route('admin.statistics.index')->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroy(\App\Models\Statistic $statistic)
    {
        $statistic->delete();
        return redirect()->back()->with('success', 'Statistik berhasil dihapus.');
    }

    public function publicIndex()
    {
        $statistics = \App\Models\Statistic::where('is_published', true)->orderBy('created_at', 'desc')->get();
        return view('pages.statistics_index', compact('statistics'));
    }

    public function publicShow($slug)
    {
        $statistic = \App\Models\Statistic::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $chartData = $statistic->chart_data;
        $publicTitle = $statistic->title;
        $publicDescription = $statistic->description;

        return view('pages.statistics', compact('chartData', 'publicTitle', 'publicDescription', 'statistic'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2048',
        ]);

        $file = $request->file('file');
        // ... (Same parsing logic as before)
        $data = [];
        $firstLine = file_get_contents($file->getRealPath(), false, null, 0, 1000);
        $delimiter = (strpos($firstLine, ';') !== false) ? ';' : ',';

        if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
            $headers = fgetcsv($handle, 1000, $delimiter);
            if ($headers) {
                $headers = array_map('trim', $headers);
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                    if ($row && count($row) == count($headers)) {
                        $row = array_map('trim', $row);
                        $data[] = array_combine($headers, $row);
                    }
                }
            }
            fclose($handle);
        }

        if (empty($data)) {
            return redirect()->back()->with('error', 'File kosong atau tidak valid.');
        }

        $headerKeys = array_keys($data[0]);
        $hasKMD = in_array('Sertifikat KMD', $headerKeys);
        $hasKML = in_array('Sertifikat KML', $headerKeys);

        if ($hasKMD && $hasKML) {
            $totalSudahKMD = 0; $totalSudahKML = 0; $totalBelumKMD = 0;
            foreach ($data as $item) {
                $isKMD = !empty($item['Sertifikat KMD']) && trim($item['Sertifikat KMD']) !== '-';
                $isKML = !empty($item['Sertifikat KML']) && trim($item['Sertifikat KML']) !== '-';
                if ($isKMD) $totalSudahKMD++; else $totalBelumKMD++;
                if ($isKML) $totalSudahKML++;
            }
            $aggregatedData = ['Sudah KMD' => $totalSudahKMD, 'Sudah KML' => $totalSudahKML, 'Belum KMD' => $totalBelumKMD];
            $labelName = 'Jumlah Pembina';
        } else {
            $labelKey = $headerKeys[2] ?? $headerKeys[0];
            $valueKey = null;
            foreach ($headerKeys as $key) { if ($key !== $labelKey && is_numeric($data[0][$key])) { $valueKey = $key; break; } }
            $aggregatedData = [];
            foreach ($data as $item) {
                $label = $item[$labelKey] ?: 'Lainnya';
                $aggregatedData[$label] = ($aggregatedData[$label] ?? 0) + ($valueKey ? (float) $item[$valueKey] : 1);
            }
            arsort($aggregatedData);
            $aggregatedData = array_slice($aggregatedData, 0, 15, true);
            $labelName = $valueKey ? 'Total ' . $valueKey : 'Jumlah Berdasarkan ' . $labelKey;
        }

        session(['chartData' => [
            'labels' => array_keys($aggregatedData),
            'values' => array_values($aggregatedData),
            'labelName' => $labelName
        ]]);

        return redirect()->back()->with('success', 'Data berhasil diproses. Beri judul dan simpan untuk publikasi.');
    }
}
