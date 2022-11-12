<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'chat_user';

    protected $fillable = ['chat_id', 'user_id'];
}
