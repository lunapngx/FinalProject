<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'user';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'admin' => [
            'title'       => 'Admin',
            'description' => 'Day to day administrators of the site.',
        ],
        'developer' => [
            'title'       => 'Developer',
            'description' => 'Site programmers.',
        ],
        'user' => [
            'title'       => 'User',
            'description' => 'General users of the site. Often customers.',
        ],
        'beta' => [
            'title'       => 'Beta User',
            'description' => 'Has access to beta-level features.',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        // Existing admin/user management permissions
        'admin.access'        => 'Can access the sites admin area',
        'admin.settings'      => 'Can access the main site settings',
        'users.manage-admins' => 'Can manage other admins', // For superadmin
        'users.create'        => 'Can create new non-admin users',
        'users.edit'          => 'Can edit existing non-admin users',
        'users.delete'        => 'Can delete existing non-admin users',
        'beta.access'         => 'Can access beta-level features',

        // --- NEW SHOPPING SYSTEM PERMISSIONS ---

        // Product Management
        'products.view'       => 'Can view all products', // For customers to browse
        'products.create'     => 'Can add new products',
        'products.edit'       => 'Can edit existing products',
        'products.delete'     => 'Can delete products',
        'products.manage'     => 'Can manage product inventory (view/update stock)', // General management

        // Category Management
        'categories.view'     => 'Can view all categories', // For customers to browse
        'categories.create'   => 'Can add new categories',
        'categories.edit'     => 'Can edit existing categories',
        'categories.delete'   => 'Can delete categories',

        // Order Management
        'orders.view_all'     => 'Can view all orders in the system', // For admins
        'orders.view_own'     => 'Can view their own orders',         // For customers
        'orders.create'       => 'Can place new orders',               // For customers
        'orders.update_status'=> 'Can change order statuses',          // For admins
        'orders.cancel_any'   => 'Can cancel any order',               // For admins
        'orders.cancel_own'   => 'Can cancel their own order',         // For customers

        // User Profile & Addresses (for customers)
        'profile.manage'      => 'Can update their own user profile details (name, phone)',
        'addresses.manage_own'=> 'Can add, edit, delete their own addresses',

        // Payments Management
        'payments.view_all'   => 'Can view all payment records',
        'payments.refund'     => 'Can issue refunds',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'superadmin' => [
            'admin.*',
            'users.*',
            'beta.*',
            // Superadmin automatically gets all newly added permissions if they are under 'products.*', 'categories.*' etc.
            // You might consider adding 'shop.*' if you group them all under a main shop context.
        ],
        'admin' => [
            'admin.access',
            'users.create',
            'users.edit',
            'users.delete',
            'beta.access',
            // --- NEW ADMIN PERMISSIONS ---
            'products.create',
            'products.edit',
            'products.delete',
            'products.manage',
            'categories.create',
            'categories.edit',
            'categories.delete',
            'orders.view_all',
            'orders.update_status',
            'orders.cancel_any',
            'payments.view_all',
            'payments.refund',
        ],
        'developer' => [
            'admin.access',
            'admin.settings',
            'users.create',
            'users.edit',
            'beta.access',
            // Developers might also get access to product/category/order viewing for debugging
            'products.view',
            'categories.view',
            'orders.view_all',
            'payments.view_all',
        ],
        'user' => [ // <-- Assign permissions for your regular customers here
            'products.view',
            'categories.view',
            'orders.create',
            'orders.view_own',
            'orders.cancel_own',
            'profile.manage',
            'addresses.manage_own',
        ],
        'beta' => [
            'beta.access',
        ],
    ];
}
