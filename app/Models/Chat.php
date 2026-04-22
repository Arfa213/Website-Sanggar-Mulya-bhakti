<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['pesan_user', 'jawaban_ai', 'model_used'];
}
