<?php

namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureShopIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $shop = $request->route('shop');
 
        // Boutique expirée ou désactivée : la page n'existe plus pour les clients
        abort_unless($shop && $shop->isActive(), 404);
 
        return $next($request);
    }
}