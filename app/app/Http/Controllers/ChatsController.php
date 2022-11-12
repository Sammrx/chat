<?php

namespace App\Http\Controllers;

use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userCount = User::count();
        return view('chat', compact('userCount'));
    }

    public function home()
    {
        $userCount = User::count();
        return view('welcome', compact('userCount'));
    }

    public function fetchMessages()
    {
        $chatId = ChatUser::whereUserId(Auth::user()->id)->first();

        $messages = Message::with('user')
            ->join('chat_user', 'messages.user_id', '=', 'chat_user.user_id')
            ->where('chat_user.chat_id', $chatId->chat_id)
            ->get();

        return $messages;
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();
        return ['status' => 'Message Sent!'];
    }
}
