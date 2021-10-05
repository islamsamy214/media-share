<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_messages'])->only(['index', 'show']);
        $this->middleware(['permission:create_messages'])->only('store');
        $this->middleware(['permission:update_messages'])->only('update');
        $this->middleware(['permission:delete_messages'])->only('destroy');
    } //end of construct


    public function index()
    {
        return response(Contact::first(), 200);
    } //end of index


    public function edit(Contact $contact)
    {
        $contact = Contact::first();
        return response()->json($contact, 200);
    } //end of edit


    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact = Contact::first();
        $contact->update($request->all());
        return response()->json('contact info updated successfully', 200);
    } //end of update
}
