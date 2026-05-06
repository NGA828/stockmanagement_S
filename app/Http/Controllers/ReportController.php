<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.form');
    }

    public function store(Request $request)
    {
        $request->validate(['type' => 'required|string']);

        Report::create([
            'type' => $request->type,
            'generated_date' => now(),
            'generated_by' => auth()->id(),
            'parameters' => $request->except(['_token']),
            'file_path' => 'reports/temp_' . time() . '.pdf',
        ]);

        return redirect()->route('reports.index')->with('success', 'Report generated (Placeholder).');
    }
}
