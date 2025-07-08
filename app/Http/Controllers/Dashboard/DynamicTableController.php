<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\DynamicColumn;

use App\Http\Controllers\Controller;
use App\Models\DynamicTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DynamicTableController extends Controller
{
    public function show(DynamicTable $table)
    {
        $table->load('columns');
        return view('dashboard.tables.show', compact('table'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = DynamicTable::latest()->get();
        return view('dashboard.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('dashboard.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:dynamic_tables,name',
        ]);

        DynamicTable::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('dashboard.tables.index')->with('success', 'Table created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
