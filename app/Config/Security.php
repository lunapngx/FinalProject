<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

// app/Config/Security.php
class Security extends BaseConfig
{
    public string $csrfProtection = 'session';
    public bool $tokenRandomize  = true; // Stronger security
    public string $tokenName     = 'csrf_test_name';
    public string $headerName    = 'X-CSRF-TOKEN';
    public string $cookieName    = 'csrf_t_name'; // <-- ADD THIS LINE BACK
    public int $expires          = 7200;
    public bool $regenerate      = true; // IMPORTANT: Set to true for new token on each request
    public bool $redirect        = (ENVIRONMENT === 'production'); // Redirects on CSRF failure in production
}