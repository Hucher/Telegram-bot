<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/telegram',
        '/618697008:AAEphoqxA0ELU7E0fbB-lVhubZ9TxZw1kT4/webhook'
    ];
}
