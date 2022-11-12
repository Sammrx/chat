<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $chat = DB::select('SELECT chat_id, COUNT(*) c FROM chats GROUP BY chat_id HAVING c < 2');
        $chat = json_decode(json_encode($chat), true);
        $chatId = null;

        if (empty($chat)) {
            $lastChat = DB::table('chats')->select('chat_id')->orderByDesc('chat_id')->limit('0, 1')->first();
            if (!$lastChat) {
                $chatId = 1;
            }
            if ($lastChat) {
                $lastChat = json_decode(json_encode($lastChat), true);
                $chatId = $lastChat['chat_id']+1;
            }
        }
        if ($chat) {
            $chatId = $chat[0]['chat_id'];
        }

        if ($chatId) {
            $newChat = new Chat();

            $newChat->chat_id = $chatId;
            $newChat->user_id = $user->id;
            $newChat->save();
        }

        return $user;
    }
}
