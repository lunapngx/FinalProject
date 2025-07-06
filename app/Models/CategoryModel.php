<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories'; // Make sure your category table is named 'categories'
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Or 'object'
    protected $useSoftDeletes = false; // Set to true if you use soft deletes

    // These fields must match the columns in your 'categories' database table
    protected $allowedFields = [
        'name',
        'slug', // Essential for clean URLs if you use slugs
        'description', // Optional: if your categories have descriptions
        // Add other category-related fields here
    ];

    // Dates
    protected $useTimestamps = false; // Set to true if you have 'created_at', 'updated_at', etc.
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}