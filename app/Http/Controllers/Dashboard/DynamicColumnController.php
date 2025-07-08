<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DynamicTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DynamicColumnController extends Controller
{
    public function store(Request $request, DynamicTable $table)
    {
        $request->validate([
            'column_name' => 'required|string|max:255',
            'column_type' => 'required|string|in:text,textarea,number,date,datetime-local,email,password,file',
            'validation_rules' => 'nullable|string',
        ]);

        $table->columns()->create([
            'column_name' => $request->column_name,
            'column_slug' => Str::slug($request->column_name, '_'),
            'column_type' => $request->column_type,
            'validation_rules' => $request->validation_rules ? explode('|', $request->validation_rules) : null,
        ]);

        return back()->with('success', 'Column added successfully.');
    }
}
