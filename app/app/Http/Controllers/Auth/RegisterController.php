<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ChatUser;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['name'].uniqid().'@samchat.com';
        $user->password = Hash::make(uniqid());
        $user->save();

        $chat = DB::table('chat_user')
            ->select(DB::raw('count(*) as c, chat_id'))
            ->groupBy('chat_id')
            ->having('c', '<', 2)
            ->first();

        $chatId = Str::uuid();

        if ($chat) {
            $chatId = $chat->chat_id;
        }

        $chat = new ChatUser();
        $chat->chat_id = $chatId;
        $chat->user_id = $user->id;
        $chat->save();

        return $user;
    }

    public function showRegistrationForm()
    {
        $userCount = User::count();
        return view('welcome',  compact('userCount'));
    }
}
