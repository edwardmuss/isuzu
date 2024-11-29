<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Loyalty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LoyaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loyalty = Loyalty::first();
        return view('loyalty.index', compact('loyalty'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Loyalty $loyalty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loyalty $loyalty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loyalty $loyalty)
    {
        //
    }

    public function updateOrCreate(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'email_subject' => 'required|string|max:255',
            'sms_message' => 'nullable|string',
            'email_body' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        $loyalty = Loyalty::find($request->id) ?? Loyalty::firstOrNew(['title' => $request->input('title')]);

        $loyalty->fill($request->only(['title', 'email_subject', 'sms_message', 'email_body']));

        // Handle file upload
        if ($request->hasFile('file')) {
            if ($loyalty->file) {
                Storage::disk('public')->delete($loyalty->file); // Delete old file
            }
            $loyalty->file = $request->file('file')->store('loyalty_files', 'public');
        }

        // Save the record
        $loyalty->save();

        return redirect()->back()->with('success', 'Loyalty entry updated or created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loyalty $loyalty)
    {
        //
    }
}
