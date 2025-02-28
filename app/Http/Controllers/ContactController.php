<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000'
        ]);

        try {
            // Save to database
            $contactSubmission = ContactSubmission::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'] ?? null,
                'message' => $validatedData['message'],
                'status' => 'new',  // Optional: set initial status
                'assigned_to' => null  // Optional: no initial assignment
            ]);

            return redirect()
                ->route('contact.index')
                ->with('success', 'Cảm ơn bạn đã liên hệ. Tin nhắn của bạn đã được ghi nhận.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.')
                ->withInput();
        }
    }
}
