<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SisranForm;
use App\Models\SisranField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SisranController extends Controller
{
    public function index()
    {
        $forms = SisranForm::withCount('entries')->orderBy('created_at', 'desc')->get();
        return view('admin.sisran.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.sisran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|in:text,number,select,radio,checkbox',
        ]);

        $form = SisranForm::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'category' => $request->category,
            'description' => $request->description,
        ]);

        foreach ($request->fields as $index => $fieldData) {
            SisranField::create([
                'sisran_form_id' => $form->id,
                'label' => $fieldData['label'],
                'type' => $fieldData['type'],
                'options' => $fieldData['options'] ?? null,
                'order' => $index,
            ]);
        }

        return redirect()->route('admin.sisran.index')->with('success', 'Form SISRAN berhasil dibuat.');
    }

    public function edit(SisranForm $sisran)
    {
        $sisran->load('fields');
        return view('admin.sisran.edit', compact('sisran'));
    }

    public function update(Request $request, SisranForm $sisran)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|in:text,number,select,radio,checkbox',
        ]);

        $sisran->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        // Handing field sync
        $existingFieldIds = $sisran->fields()->pluck('id')->toArray();
        $updatedFieldIds = [];

        foreach ($request->fields as $index => $fieldData) {
            if (isset($fieldData['id']) && in_array($fieldData['id'], $existingFieldIds)) {
                // Update existing
                $field = SisranField::find($fieldData['id']);
                $field->update([
                    'label' => $fieldData['label'],
                    'type' => $fieldData['type'],
                    'options' => $fieldData['options'] ?? null,
                    'order' => $index,
                ]);
                $updatedFieldIds[] = $field->id;
            } else {
                // Create new
                $newField = SisranField::create([
                    'sisran_form_id' => $sisran->id,
                    'label' => $fieldData['label'],
                    'type' => $fieldData['type'],
                    'options' => $fieldData['options'] ?? null,
                    'order' => $index,
                ]);
                $updatedFieldIds[] = $newField->id;
            }
        }

        // Delete fields that were removed in UI
        $fieldsToDelete = array_diff($existingFieldIds, $updatedFieldIds);
        SisranField::destroy($fieldsToDelete);

        return redirect()->route('admin.sisran.index')->with('success', 'Form SISRAN berhasil diperbarui.');
    }

    public function destroy(SisranForm $sisran)
    {
        $sisran->delete();
        return redirect()->route('admin.sisran.index')->with('success', 'Form berhasil dihapus.');
    }

    public function entries(SisranForm $sisran_form)
    {
        $entries = $sisran_form->entries()->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.sisran.entries', compact('sisran_form', 'entries'));
    }

    public function visualizeIndex()
    {
        $forms = SisranForm::withCount('entries')->orderBy('created_at', 'desc')->get();
        return view('admin.sisran.visualize_index', compact('forms'));
    }

    public function visualizeShow(SisranForm $sisran_form)
    {
        $sisran_form->load('fields');
        return view('admin.sisran.visualize_show', compact('sisran_form'));
    }

    public function visualizeUpdate(Request $request, SisranForm $sisran_form)
    {
        foreach ($request->fields as $fieldId => $chartType) {
            SisranField::where('id', $fieldId)
                ->where('sisran_form_id', $sisran_form->id)
                ->update(['chart_type' => $chartType]);
        }

        return redirect()->back()->with('success', 'Pengaturan visualisasi berhasil disimpan.');
    }
}
