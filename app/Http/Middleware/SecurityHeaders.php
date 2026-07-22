<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Daftar direktif Content Security Policy.
     * Dipisah per-direktif agar mudah dimaintain.
     */
    private array $cspDirectives = [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net",
        "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net",
        "font-src 'self' https://cdn.jsdelivr.net data:",
        "img-src 'self' data: https:",
        "connect-src 'self'",
        "frame-src 'none'",
        "frame-ancestors 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "object-src 'none'",
        "upgrade-insecure-requests",
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ── 1. Clickjacking protection ──────────────────────────────────────
        $response->headers->set('X-Frame-Options', 'DENY');

        // ── 2. MIME-type sniffing prevention ────────────────────────────────
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ── 3. Legacy XSS filter (IE/Edge lama) ────────────────────────────
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ── 4. Referrer policy ──────────────────────────────────────────────
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ── 5. Permissions / Feature policy ────────────────────────────────
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()'
        );

        // ── 6. HSTS — only in production (avoid breaking local HTTP dev) ───
        if (config('app.env') === 'production') {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        // ── 7. Content Security Policy ──────────────────────────────────────
        $response->headers->set(
            'Content-Security-Policy',
            implode('; ', $this->cspDirectives)
        );

        // ── 8. Hapus header yang mengekspos teknologi stack ─────────────────
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
