<?php

namespace App\Http\Controllers;

use App\Models\DynamicRow;
use App\Models\DynamicTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DynamicResourceController extends Controller
{
    // Helper untuk mendapatkan tabel dan kolom
    private function getTable(string $slug): DynamicTable
    {
        return DynamicTable::with('columns')->where('slug', $slug)->firstOrFail();
    }

    // Menampilkan daftar data
    public function index(string $table_slug)
    {
        $table = $this->getTable($table_slug);

        // Eager load relasi untuk efisiensi
        $rows = DynamicRow::where('dynamic_table_id', $table->id)
            ->with('values.dynamicColumn')
            ->latest()
            ->paginate(15);

        // Mengubah data EAV menjadi format koleksi yang lebih mudah digunakan di view
        $data = $rows->map(function ($row) {
            $rowData = ['id' => $row->id]; // Simpan ID baris untuk link edit/delete
            foreach ($row->values as $value) {
                $rowData[$value->dynamicColumn->column_slug] = $value->value;
            }
            return (object) $rowData;
        });

        return view('dynamic.index', [
            'table' => $table,
            'columns' => $table->columns,
            'data' => $data,
            'rows' => $rows // Kirim paginator asli untuk link
        ]);
    }

    // Menampilkan form create
    public function create(string $table_slug)
    {
        $table = $this->getTable($table_slug);
        return view('dynamic.form', [
            'table' => $table,
            'columns' => $table->columns,
        ]);
    }

    // Menyimpan data baru
    public function store(Request $request, string $table_slug)
    {
        $table = $this->getTable($table_slug);

        // Membuat aturan validasi dan nama atribut dinamis
        $rules = [];
        $attributes = [];
        foreach ($table->columns as $column) {
            if ($column->validation_rules) {
                $rules[$column->column_slug] = $column->validation_rules;
            }
            $attributes[$column->column_slug] = $column->column_name;
        }

        $validator = Validator::make($request->all(), $rules, [], $attributes);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Gunakan transaction untuk memastikan integritas data
        DB::transaction(function () use ($request, $table) {
            $row = $table->rows()->create([
                'user_id' => Auth::id(), // Asumsikan ada relasi user_id
            ]);

            foreach ($table->columns as $column) {
                if ($request->has($column->column_slug)) {
                    $value = $request->input($column->column_slug);

                    // Handle file upload
                    if ($request->hasFile($column->column_slug)) {
                        $value = $request->file($column->column_slug)->store('dynamic_uploads', 'public');
                    }

                    $row->values()->create([
                        'dynamic_column_id' => $column->id,
                        'value' => $value,
                    ]);
                }
            }
        });

        return redirect()->route('dynamic.index', $table->slug)->with('success', 'Data saved successfully.');
    }
}
