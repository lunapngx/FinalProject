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
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'adminAuth'     => \App\Filters\AdminAuthFilter::class,
        'auth'          => \App\Filters\AuthFilter::class,
    ];

    // app/Config/Filters.php

    public array $globals = [
        'before' => [
            'csrf', // Ensure 'csrf' is listed here
            // 'honeypot',
            // 'toolbar',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    public array $methods = [];

    // This is where you apply filters to specific routes or groups
    public array $filters = [
        'adminAuth' => [
            'before' => [
                'admin/*', // Apply to all routes under the 'admin' group
            ],
            // IMPORTANT: Exclude login, register, and logout routes from the adminAuth filter
            'except' => [
                'admin/login',
                'admin/register',
                'admin/logout',
            ],
        ],
        'auth' => [
            'before' => [
                'account/*',
            ],
            'except' => [
                'login',
                'register',
                'logout',
                'account/login',
                'account/register',
                'account/logout',
            ],
        ],
    ];
}