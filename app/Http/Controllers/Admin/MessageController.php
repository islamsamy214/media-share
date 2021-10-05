<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplyRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_messages'])->only(['index', 'show']);
        $this->middleware(['permission:create_messages'])->only('store');
        $this->middleware(['permission:update_messages'])->only('update');
        $this->middleware(['permission:delete_messages'])->only('destroy');
    } //end of construct

    public function index(Request $request)
    {
        if ($request->search) {
            $messages = $this->searchMessage($request);
        } else {
            $messages = Message::latest()->paginate(10);
        }
        return response()->json($messages, 200);
    } //end of index


    private function searchMessage($request)
    {
        return Message::where('sender_name', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%')
            ->orWhere('subject', 'like', '%' . $request->search . '%')
            ->latest()->paginate(10);
    } //end of searchMessage


    public function store(StoreReplyRequest $request)
    {
        $user = auth()->user();
        $this->sendMail($request, $user);
        $this->storeReplyRelation($request, $user);
        return response()->json('reply sent successfully', 200);
    } //end of store


    private function sendMail($request, $user)
    {
        Mail::send('messages', [
            'message_content' => $request->content
        ], function ($message) use ($request, $user) {
            $message->to(
                $request->email,
                $request->sender_name
            )->subject($request->subject);
            $message->from(
                Contact::select('email')->first()->email,
                $user->name
            )->subject($request->subject);
        });
    } //end of sendMail


    private function storeReplyRelation($request, $user)
    {
        $user->replies()->attach($request->message_id, [
            'content' => $request->content,
            'created_at' => now()
        ]);
    } //end of storeReplyRelation


    public function show(Message $message)
    {
        $message->update(['read' => true]);
        $message['replies'] = $message->replies;
        return response()->json($message, 200);
    } //end of show


    public function destroy(Message $message)
    {
        $message->replies()->detach();
        $message->delete();
        return response()->json('message deleted successfully', 200);
    } //end of destroy
}
