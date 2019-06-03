<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Validation\ValidationException;

class TransformUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $input = $request->all();

        if( !isset($input["url"]) )
            throw ValidationException::withMessages(["Server error: Url field is required to perform this action"]);

        $input['url'] = str_replace(' ', "%20", $input['url']);
        $input['url'] = filter_var($input['url'], FILTER_SANITIZE_URL);

        $request->replace($input);

        return $next($request);
    }
}
