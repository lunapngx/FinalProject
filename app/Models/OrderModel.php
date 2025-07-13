<?php namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders'; // <--- IMPORTANT: Replace 'orders' with your actual orders table name
    protected $primaryKey = 'id'; // <--- IMPORTANT: Replace 'id' with your actual primary key

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Add all column names from your 'orders' table that you intend to interact with
    protected $allowedFields = [
        // Example: 'user_id', 'product_id', 'quantity', 'total_amount', 'status', 'order_date'
    ];

    protected $useTimestamps = true; // Set to true if you have created_at/updated_at columns
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Add any other model properties or methods as needed for your OrderModel
}
