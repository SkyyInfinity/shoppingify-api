<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestMail(): void
    {
        Mail::to('john.doe@gmail.com')->send(new TestMail());
    }
}
