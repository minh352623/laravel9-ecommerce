<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function index()
    {
        return view('clients.contact');
    }

    public function add(Request $request)
    {
        $email = $request->email;
        $message = $request->msg;

        if ($email != "" && $message != '') {
            $contact = new Contact();

            $contact->email = $email;
            $contact->message = $message;

            $contact->save();
            return back()->with('msg', 'Gửi liên hệ thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất.');
        }
    }
}
