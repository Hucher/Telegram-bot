<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $fillable = [
      'text',
    ];

    public function user()
    {
        return $this->belongsTo(TelegramUser::class);
    }
}
