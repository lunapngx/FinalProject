<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Libraries\MyCart; // Use the newly created custom Cart class

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /**
     * The Cart service.
     *
     * @param bool $getShared Whether to return a shared instance or a new one.
     * @return \App\Libraries\MyCart
     */
    public static function cart(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('cart');
        }

        // Instantiate your actual Cart class here
        // We are now using the custom MyCart class
        return new MyCart(); // Instantiate your custom cart class
    }

    /*
     * public static function example($getShared = true)
     * {
     * if ($getShared) {
     * return static::getSharedInstance('example');
     * }
     *
     * return new \CodeIgniter\Example();
     * }
     */
}