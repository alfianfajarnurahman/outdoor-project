<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;

class ResolveBranch
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        
        // Ambil subdomain (bagian sebelum titik pertama)
        $subdomain = explode('.', $host)[0];
        
        // Abaikan jika localhost, www, admin, api, atau 127.0.0.1
        $ignore = ['localhost', 'www', 'admin', 'api', '127.0.0.1'];
        
        if (!in_array($subdomain, $ignore)) {
            $branch = Branch::where('domain', $subdomain)->first();
            
            if ($branch) {
                // Simpan branch di request
                $request->attributes->set('branch', $branch);
                // Simpan di container
                app()->instance('current_branch', $branch);
            }
        }
        
        return $next($request);
    }
}