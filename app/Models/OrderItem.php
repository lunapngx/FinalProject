<?php namespace App\Models;

use CodeIgniter\Model;

class OrderItem extends Model
{
    protected $table      = 'order_items'; // Ensure your order items table is named 'order_items'
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Or 'object'
    protected $useSoftDeletes = false; // Set to true if you use soft deletes

    protected $allowedFields = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
        'options', // Stores product options (like color, size) usually as JSON
    ];

    // Dates
    protected $useTimestamps = true; // Set to true if you have 'created_at', 'updated_at', etc.
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation (add rules as needed)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}