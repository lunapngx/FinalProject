<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Get Shield's user model
        $users = auth()->getProvider();

        // Check if the admin user already exists
        if ($users->findByCredentials(['username' => 'admin'])) {
            echo "✅ Admin user already exists. Skipping creation.\n";
            return;
        }

        // If user doesn't exist, create them
        echo "Admin user not found. Creating now...\n";

        $user = new User([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => 'adminpassword',
            'active'   => 1,
        ]);
        $users->save($user);

        // Get the ID of the user we just created
        $userId = $users->getInsertID();

        // Get the group model
        $groupModel = model('GroupModel');
        $adminGroup = $groupModel->where('name', 'admin')->first();

        // Add the user to the 'admin' group
        $groupModel->addUserToGroup($userId, $adminGroup->id);

        echo "✅ Admin user created and assigned to the 'admin' group successfully!\n";
    }
}