<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGsmBoxPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userGsmPermissions = json_decode(auth()->user()->gsm_permissions, true);
        $provider = strtolower(str_replace(' ', '', $request->provider));
        $port = $request->port;

        if ($userGsmPermissions && $userGsmPermissions[$provider]) {
            if (in_array($port, $userGsmPermissions[$provider])) {
                return $next($request);
            }
            return response()->json('You do not have permission to send sms through these ports!', 403);
        }
        return response()->json('You do not have permission to send sms through this provider!',403);
    }
}
