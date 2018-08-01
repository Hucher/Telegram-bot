<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $guarded = [];

    public function messages()
    {
        return $this->hasMany(TelegramMessage::class);
    }
}
