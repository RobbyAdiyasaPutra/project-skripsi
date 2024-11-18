<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',         // Untuk Facebook Click Identifier
        // 'utm_campaign',   // Untuk UTM tracking campaign
        // 'utm_content',    // Untuk UTM tracking konten
        // 'utm_medium',     // Untuk UTM tracking medium
        // 'utm_source',     // Untuk UTM tracking sumber
        // 'utm_term',       // Untuk UTM tracking term
    ];

    /**
     * Perform the signature validation check.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function handle($request, \Closure $next)
    {
        // Exclude query parameters from signature validation
        $request->query->add(array_fill_keys($this->except, ''));

        return parent::handle($request, $next);
    }
}
