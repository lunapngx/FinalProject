<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // !!! IMPORTANT: This MUST match your actual users table name in your database.
    protected $table = 'users'; // Example: 'users', 'my_users_table'

    // !!! IMPORTANT: This MUST match the primary key column name of your users table.
    protected $primaryKey = 'id'; // Example: 'id', 'user_id'

    protected $useAutoIncrement = true; // Set to true if your primary key is auto-incrementing

    protected $returnType     = 'array'; // Data will be returned as arrays. Change to 'object' if you prefer objects.
    protected $useSoftDeletes = false;   // Set to true if your table has a 'deleted_at' column for soft deletes.

    // !!! CRITICAL: List ALL database column names that you allow to be inserted or updated via $userModel->save().
    // If a field is not listed here, it will be ignored when you try to save it.
    protected $allowedFields = [
        'fullname',
        'username',
        'email',
        'password_hash', // This stores the hashed password
        'role',          // e.g., 'user', 'admin'
        'active',        // e.g., 0 for inactive, 1 for active
        'status',        // e.g., 'pending', 'active', 'banned'
        // Add any other columns from your 'users' table that your application will set/update.
        // For example, if you have 'phone', 'address', etc., add them here.
    ];

    // --- Timestamps Configuration ---
    // Set to true if your database table automatically manages 'created_at' and 'updated_at' columns.
    // If your table has these columns, set useTimestamps to true.
    protected $useTimestamps = true;
    protected $createdField  = 'created_at'; // Name of the 'created at' column in your DB
    protected $updatedField  = 'updated_at'; // Name of the 'updated at' column in your DB
    protected $deletedField  = 'deleted_at'; // Name of the 'deleted at' column (only if useSoftDeletes is true)

    // --- Validation Rules (Optional but Recommended) ---
    // You can define validation rules here for data inserted/updated via the model.
    // If you have validation in your controller (like in AuthController::register),
    // these model-level rules can be supplementary or a fallback.
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false; // Set to true to bypass model's internal validation during save()

    // --- Callbacks (Optional) ---
    // These methods can be used to perform actions before/after database operations.
    // protected $beforeInsert = [];
    // protected $afterInsert  = [];
    // protected $beforeUpdate = [];
    // protected $afterUpdate  = [];
    // protected $afterFind    = [];
    // protected $afterDelete  = [];
}
