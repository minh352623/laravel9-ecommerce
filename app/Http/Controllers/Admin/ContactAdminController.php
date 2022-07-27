<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactAdminController extends Controller
{
    //
    const PER_PAGE = 5;
    public function index(Request $request)
    {
        if ($request->censorship && $request->censorship > 0) {
            // dd($request->censorship);
            $contact = Contact::find($request->censorship);
            $contact->status = 1;
            $contact->save();
            return back();
        } else {

            $contacts =  DB::table('contacts');
            if (!empty($request->status)) {
                $status = $request->status;

                if ($request->status == 2) {
                    $status = 0;
                }

                $contacts = $contacts->where('status', $status);
            }
            if (!empty($request->keyword)) {
                $contacts = $contacts->where('email', 'like', '%' . $request->keyword . '%');
            }
            $contacts = $contacts->paginate(self::PER_PAGE);
            return  view('admin.contact.lists', compact('contacts'));
        }
    }
}
