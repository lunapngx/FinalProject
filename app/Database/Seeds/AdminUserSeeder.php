<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User; // Use Shield's User entity

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Get Shield's user model
        $users = auth()->getProvider();

        // Check if the admin user already exists by username
        // Note: Shield's findByCredentials usually checks email/username.
        // For simple check, findByUsername() is also an option if available.
        if ($users->findByCredentials(['username' => 'admin'])) {
            echo "✅ Admin user 'admin' already exists. Skipping creation.\n";
            return;
        }

        // If user doesn't exist, create them
        echo "Admin user 'admin' not found. Creating now...\n";

        // Create a new user entity for Shield
        $user = new User([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => 'adminpassword', // Shield handles hashing this password automatically on save
            'active'   => 1, // Set to active
        ]);

        // Save the user via Shield's provider
        $users->save($user);

        // Get the ID of the user we just created
        $userId = $users->getInsertID();

        // Get the group model from Shield
        // Ensure you have a 'GroupModel' aliased or direct use statement if needed.
        // If 'GroupModel' is Shield's default, it might be in `CodeIgniter\Shield\Models\GroupModel`.
        // The `model()` helper assumes it's globally resolvable or aliased.
        $groupModel = model('GroupModel');
        $adminGroup = $groupModel->where('name', 'admin')->first();

        // Check if admin group exists, if not, create it or handle error
        if (!$adminGroup) {
            echo "⚠️ 'admin' group not found. Creating it now...\n";
            $groupModel->insert(['name' => 'admin', 'description' => 'Administrator users']);
            $adminGroup = $groupModel->where('name', 'admin')->first(); // Fetch again after creation
            if (!$adminGroup) {
                echo "❌ Failed to create 'admin' group. Admin user not assigned to group.\n";
                return;
            }
        }

        // Add the user to the 'admin' group
        $groupModel->addUserToGroup($userId, $adminGroup->id);

        echo "✅ Admin user 'admin' created and assigned to the 'admin' group successfully!\n";
    }
}