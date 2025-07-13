<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel; // Use the UserModel
use App\Models\AdminModel; // Temporarily use AdminModel to fetch old admin data

class MigrateAdminsToUsersSeeder extends Seeder
{
    public function run()
    {
        $adminModel = new AdminModel();
        $userModel = new UserModel();

        $admins = $adminModel->findAll(); // Get all existing admins

        foreach ($admins as $admin) {
            // Check if a user with this username or email already exists
            $existingUser = $userModel->where('username', $admin['username'])
                ->orWhere('email', $admin['username'] . '@example.com') // Assuming admin username can be used as part of email if no email exists
                ->first();

            if (!$existingUser) {
                // Prepare data for the users table
                $userData = [
                    'username'      => $admin['username'],
                    // If your admin table has an email, use it. Otherwise, create a dummy one.
                    'email'         => $admin['username'] . '@example.com', // YOU MUST ADJUST THIS LOGIC
                    'password_hash' => $admin['password'], // Password is already hashed
                    'fullname'      => $admin['fullname'] ?? null, // Use fullname if available
                    'role'          => 'admin', // Set the role to admin
                    'created_at'    => $admin['created_at'] ?? date('Y-m-d H:i:s'),
                    'updated_at'    => $admin['updated_at'] ?? date('Y-m-d H:i:s'),
                    // Add other necessary fields as per your users table schema
                    'status'        => 'active',
                    'active'        => 1,
                ];
                $userModel->save($userData);
                echo "Migrated admin: " . $admin['username'] . "\n";
            } else {
                echo "Admin '" . $admin['username'] . "' already exists in users table (or a conflicting entry). Skipping.\n";
                // Optionally, update the existing user's role to admin if they are found by username and not already admin.
                if($existingUser['username'] === $admin['username'] && ($existingUser['role'] ?? 'user') !== 'admin') {
                    $userModel->update($existingUser['id'], ['role' => 'admin']);
                    echo "Updated existing user '" . $admin['username'] . "' to role 'admin'.\n";
                }
            }
        }
        echo "Admin migration completed.\n";
    }
}