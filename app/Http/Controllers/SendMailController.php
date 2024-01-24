<?php

namespace App\Http\Controllers;

use App\Mail\AdminMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\SampleMail;

class SendMailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title'=>'Company register',
            'subject' => 'This is the mail subject',
            'body' => 'This is the email body of how to send email from laravel 10 with mailtrap.'
        ];

        Mail::to('dev@gmail.com')->send(new SampleMail($mailData));
        notify()->success('Company register mail has been send to Super admin');
        return redirect()->route('company.index');
    }
    public function response(){
        $data=[
            'title'=>'Company register',
            'subject'=>'This is the mail subject'
        ];
        Mail::to(Auth::user()->email)->send(new AdminMail($data));
        notify()->success('Company registration approved');
        return redirect()->route('company.index');
    }
}
