<?php

namespace App\Http\Middleware;

use Closure;

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

        $input['url'] = str_replace(' ', "%20", $input['url']);
        $input['url'] = filter_var($input['url'], FILTER_SANITIZE_URL);

        $request->replace($input);

        return $next($request);
    }
}
