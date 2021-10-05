<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreMessageRequest;

class MessageController extends Controller
{
    public function sendMessage(StoreMessageRequest $request)
    {
        $form_data = $request->all();
        $this->sendMail($request);
        $form_data['slug'] = str_replace(' ', '-', $request->subject);
        Message::create($form_data);
        return response()->json('message sent successfully', 200);
    } //end of sendMessage

    public function sendMail($request)
    {
        Mail::send('messages', [
            'message_content' => $request->content
        ], function ($message) use ($request) {
            $message->to(
                Contact::select('email')->first()->email,
                env('MAIL_USERNAME')
            )->subject($request->subject);
            $message->from(
                $request->email,
                $request->sender_name
            )->subject($request->subject);
        });
    } //end of sendMail
}
