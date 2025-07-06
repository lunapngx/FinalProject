<?php namespace App\Models;

use CodeIgniter\Model;

class Order extends Model
{
    protected $table      = 'orders'; // Ensure your orders table is named 'orders'
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Or 'object'
    protected $useSoftDeletes = false; // Set to true if you use soft deletes

    protected $allowedFields = [
        'user_id',
        'total_amount',
        'subtotal_amount',
        'shipping_cost',
        'shipping_address',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'payment_method',
        'status',
        // 'tracking_number', // Add if you plan to use tracking numbers
    ];

    // Dates
    protected $useTimestamps = true; // Set to true to automatically manage created_at and updated_at
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