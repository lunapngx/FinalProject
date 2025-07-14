<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Security extends BaseConfig
{
    public string $csrfProtection = 'session';
    public bool $tokenRandomize  = true; // Stronger security (set to true)
    public string $tokenName     = 'csrf_test_name';
    public string $headerName    = 'X-CSRF-TOKEN';
    public string $cookieName    = 'csrf_t_name';
    public int $expires          = 7200;
    public bool $regenerate      = true;
    public bool $redirect        = (ENVIRONMENT === 'production');
}