<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS; // Already imported, good.
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>>
     *
     * [filter_name => classname]
     * or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class, // Use the imported class directly
        'toolbar'       => DebugToolbar::class, // Use the imported class directly
        'honeypot'      => Honeypot::class, // Use the imported class directly
        'secureheaders' => SecureHeaders::class, // Use the imported class directly
        'forcehttps'    => ForceHTTPS::class, // <-- ADDED THIS LINE to define the alias
        'pagecache'     => PageCache::class, // <-- ADDED THIS LINE to define the alias for pagecache
        'performance'   => PerformanceMetrics::class, // <-- ADDED THIS LINE to define the alias for performance
        // Assuming these Shield filters are correctly installed and you intend to use them
        'session'       => \CodeIgniter\Shield\Filters\SessionAuth::class,
        'tokens'        => \CodeIgniter\Shield\Filters\TokenAuth::class,
        'groups'        => \CodeIgniter\Shield\Filters\GroupFilter::class,
        'permissions'   => \CodeIgniter\Shield\Filters\PermissionFilter::class,
        // If you are using Cors, InvalidChars, you might want to add them here as well if you plan to use them by alias.
        // 'cors'          => Cors::class,
        // 'invalidchars'  => InvalidChars::class,
    ];

    /**
     * List of special required filters.
     *
     * The filters listed here are special. They are applied before and after
     * other kinds of filters, and always applied even if a route does not exist.
     *
     * Filters set by default provide framework functionality. If removed,
     * those functions will no longer work.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#provided-filters
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Now this alias is defined
            'pagecache',  // Now this alias is defined
        ],
        'after' => [
            'pagecache',   // Now this alias is defined
            'performance', // Now this alias is defined
            'toolbar',     // This alias was already defined
        ],
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            // 'session', // Temporarily comment this out (as per your original code)
            // 'csrf',    // Uncomment if you want global CSRF protection
            // 'honeypot',// Uncomment if you want global honeypot protection
        ],
        'after' => [
            'toolbar',     // This alias was already defined
            // 'honeypot',
            // 'secureheaders',
        ],
    ];


    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'POST' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [];
}