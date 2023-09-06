<?php

namespace App\Http\Controllers;

use App\Mail\Auth\RegisterMail;
use App\Mail\Auth\VerifyMail;
use App\Mail\TestMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestMail(): JsonResponse
    {
        $name = 'Dylan Hautecoeur';

        try {
            Mail::to('john.doe@gmail.com')->send(new TestMail([
                'name' => $name,
            ]));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Email not sent!',
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'message' => 'Email sent successfully!',
            'success' => true,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function sendRegisterMail(string $to, array $data): JsonResponse
    {
        try {
            Mail::to($to)->send(new RegisterMail($data));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Email not sent!',
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'message' => 'Email sent successfully!',
            'success' => true,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function sendVerifyMail(string $to, array $data): JsonResponse
    {
        try {
            Mail::to($to)->send(new VerifyMail($data));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Email not sent!',
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'message' => 'Email sent successfully!',
            'success' => true,
        ]);
    }
}
