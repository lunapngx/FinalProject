<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    /**
     * --- IMPORTANT ---
     * The 'role' field has been removed because permissions are now handled
     * by the auth_groups and auth_groups_users tables.
     * I've also added 'is_verified' which is used in your AuthController.
     */
    protected $allowedFields = [
        'fullname',
        'username',
        'email',
        'password_hash',
        'is_verified',
        'status',
        'active',
    ];

    // Timestamps configuration
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation rules
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * --- NEW METHOD ---
     * Fetches the names of all groups a user belongs to.
     * This is the correct method for your database structure.
     *
     * @param int $userId The user's ID.
     * @return array An array of group names (e.g., ['admin']).
     */
    public function getGroups(int $userId): array
    {
        // This method joins the two tables from your database screenshot
        $groups = $this->db->table('auth_groups_users')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->where('auth_groups_users.user_id', $userId)
            ->get()
            ->getResultArray();

        // Returns a simple array of group names
        return array_column($groups, 'name');
    }
}