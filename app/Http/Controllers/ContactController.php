<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            // Send email
            Mail::send('emails.contact', $validatedData, function($message) use ($validatedData) {
                $message->to(config('app.admin_email'))
                        ->subject('Liên hệ từ ' . $validatedData['name']);
            });

            return redirect()->route('contact.index')
                             ->with('success', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.')
                             ->withInput();
        }
    }
}
