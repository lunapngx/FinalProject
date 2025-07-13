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
                'account/*', // Apply to all routes under '/account'
            ],
            // If you have a unified login for both admin and regular users
            // and /login or /register are also user-facing auth routes.
            // Adjust based on how your login/register is structured.
            'except' => [
                'login',
                'register',
                'logout',
                // If you have specific user/customer login/register pages
                // 'user/login', 'user/register', 'user/logout'
            ],
        ],
    ];
}