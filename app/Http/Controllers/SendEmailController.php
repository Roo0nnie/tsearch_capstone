<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'message' => 'required|string',
        'admin_email' => 'required|email',
    ]);

    $userEmail = $validated['email'];
    $userMessage = $validated['message'];
    $adminEmail = $validated['admin_email'];

    config([
        'mail.from.address' => $userEmail,
        'mail.from.name' => 'Guest User',
    ]);

    try {

        $data = [
            'message' => $userMessage,
            'user_email' => $userEmail,
        ];

        Mail::mailer('smtp')->to($adminEmail)->send(new SendEmail($data));

        return redirect()->back()->with('success', 'Email sent successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to send. Try again.');
    }
}
}
