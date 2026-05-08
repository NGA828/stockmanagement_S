<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = \App\Models\Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        \App\Models\Client::create($data);
        return redirect()->route('clients.index')->with('success', 'Client added successfully.');
    }

    public function edit(\App\Models\Client $client)
    {
        return view('clients.form', compact('client'));
    }

    public function update(Request $request, \App\Models\Client $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $client->update($data);
        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(\App\Models\Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
