<?php

namespace App\Http\Controllers;

use App\Models\SisranForm;
use App\Models\SisranEntry;
use Illuminate\Http\Request;

class SisranPublicController extends Controller
{
    public function showForm($slug)
    {
        $form = SisranForm::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('pages.sisran.fill', compact('form'));
    }

    public function storeEntry(Request $request, $slug)
    {
        $form = SisranForm::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $rules = [
            'operator_name' => 'required|string',
            'operator_unit' => 'required|string',
        ];

        foreach ($form->fields as $field) {
            if ($field->is_required) {
                $rules['values.' . $field->id] = 'required';
            }
        }

        $validated = $request->validate($rules);

        SisranEntry::create([
            'sisran_form_id' => $form->id,
            'values' => $request->values,
            'operator_name' => $request->operator_name,
            'operator_unit' => $request->operator_unit,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dikirim. Terima kasih!');
    }

    public function showResult($slug)
    {
        $form = SisranForm::with(['fields', 'entries'])->where('slug', $slug)->firstOrFail();
        
        $chartData = [];
        foreach ($form->fields as $field) {
            // Only chart numerical data or selects for stats
            if (in_array($field->type, ['number', 'select', 'radio', 'checkbox'])) {
                $labels = [];
                $values = [];
                
                if ($field->type === 'number') {
                    // Group by operator/unit
                    foreach ($form->entries as $entry) {
                        $labels[] = $entry->operator_unit ?: 'Anonim';
                        $values[] = $entry->values[$field->id] ?? 0;
                    }
                } elseif ($field->type === 'checkbox') {
                    // For checkboxes, count occurrences of each selected option
                    $counts = [];
                    foreach ($form->entries as $entry) {
                        $vals = $entry->values[$field->id] ?? [];
                        if (is_array($vals)) {
                            foreach ($vals as $v) {
                                $counts[$v] = ($counts[$v] ?? 0) + 1;
                            }
                        }
                    }
                    $labels = array_keys($counts);
                    $values = array_values($counts);
                } else {
                    // For select and radio, count occurrences of each option
                    $counts = [];
                    foreach ($form->entries as $entry) {
                        $val = $entry->values[$field->id] ?? 'N/A';
                        $counts[$val] = ($counts[$val] ?? 0) + 1;
                    }
                    $labels = array_keys($counts);
                    $values = array_values($counts);
                }

                $chartData[] = [
                    'label' => $field->label,
                    'labels' => $labels,
                    'values' => $values,
                    'id' => $field->id,
                    'chart_type' => $field->chart_type
                ];
            }
        }

        return view('pages.sisran.result', compact('form', 'chartData'));
    }
}
