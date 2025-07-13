<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make them easier to use in Route files.
     *
     * @var array<string, class-string>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'adminAuth'     => \App\Filters\AdminAuthFilter::class, // <-- ADD THIS LINE
        'auth'          => \App\Filters\AuthFilter::class,      // <-- ADD THIS LINE (if you have a general user auth filter)
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            'csrf', // CSRF protection should almost always be global
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable the
     * appropriate global filters.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * specific route (without setting a filter in the route definition).
     *
     * Example:
     * 'admin/*' => ['foo', 'bar']
     *
     * @var array<string, array<string, string>>
     */
    public array $filters = [
        // This is where you apply filters to specific routes or groups
        'adminAuth' => [ // This applies the 'adminAuth' filter
            'before' => [
                'admin/*', // Apply to all routes under the 'admin' group
                // Add any other specific routes that need adminAuth
            ],
        ],
        // If you have a general user auth filter for non-admin pages
        'auth' => [
            'before' => [
                'account/*', // Example: apply to all routes under '/account'
                // Add other user-protected routes here
            ],
        ],
    ];
}
