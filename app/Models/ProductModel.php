<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products'; // Your products table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Or 'object' if you prefer objects
    protected $useSoftDeletes = false; // Set to true if you implement soft deletes

    // These fields must match the columns in your 'products' database table
    protected $allowedFields = [
        'name',
        'description',
        'price',
        'original_price', // Add if you have this column for sale prices
        'stock',
        'image',
        'category_id',
        'colors', // Assuming these are stored as JSON strings
        'sizes',  // Assuming these are stored as JSON strings
        // Add other product-related fields here, e.g., 'slug', 'status', 'created_at', 'updated_at'
    ];

    // Dates
    protected $useTimestamps = true; // Changed to true to automatically manage created_at and updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'        => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[5000]',
        'price'       => 'required|numeric|greater_than[0]',
        'original_price' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[price]', // Added validation for original_price
        'stock'       => 'required|integer|greater_than_equal_to[0]',
        'category_id' => 'required|integer|is_valid_category_id', // You might need to implement this custom rule
        'image'       => 'mime_in[image,image/jpg,image/jpeg,image/png,image/gif]|max_size[image,1024]', // Validates image upload
        'colors'      => 'permit_empty|json', // Validates if it's empty or valid JSON
        'sizes'       => 'permit_empty|json',  // Validates if it's empty or valid JSON
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Product name is required.',
            'min_length' => 'Product name must be at least 3 characters long.',
            'max_length' => 'Product name cannot exceed 255 characters.',
        ],
        'price' => [
            'required' => 'Price is required.',
            'numeric' => 'Price must be a number.',
            'greater_than' => 'Price must be greater than 0.',
        ],
        'original_price' => [
            'numeric' => 'Original price must be a number.',
            'greater_than_equal_to' => 'Original price must be 0 or greater.',
            'less_than_equal_to' => 'Original price cannot be greater than the current price.',
        ],
        'stock' => [
            'required' => 'Stock quantity is required.',
            'integer' => 'Stock must be an integer.',
            'greater_than_equal_to' => 'Stock cannot be negative.',
        ],
        'category_id' => [
            'required' => 'Category is required.',
            'integer' => 'Invalid category ID.',
            'is_valid_category_id' => 'Selected category is not valid.', // Message for custom rule
        ],
        'image' => [
            'uploaded' => 'Product image is required.',
            'max_size' => 'Image file is too large (max 1MB).',
            'is_image' => 'Uploaded file is not a valid image.',
            'mime_in'  => 'Only JPG, JPEG, PNG, GIF images are allowed.',
        ],
        'colors' => [
            'json' => 'Colors must be a valid JSON array or comma-separated string.',
        ],
        'sizes' => [
            'json' => 'Sizes must be a valid JSON array or comma-separated string.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setTimestamps'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['setTimestamps'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ['decodeJsonFields'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function setTimestamps(array $data)
    {
        $data['data']['created_at'] = $data['data']['created_at'] ?? date('Y-m-d H:i:s');
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function decodeJsonFields(array $data)
    {
        if (isset($data['data']['colors']) && is_string($data['data']['colors'])) {
            $data['data']['colors'] = json_decode($data['data']['colors'], true);
        }
        if (isset($data['data']['sizes']) && is_string($data['data']['sizes'])) {
            $data['data']['sizes'] = json_decode($data['data']['sizes'], true);
        }
        return $data;
    }

    protected function encodeJsonFields(array $data)
    {
        if (isset($data['data']['colors']) && is_array($data['data']['colors'])) {
            $data['data']['colors'] = json_encode($data['data']['colors']);
        }
        if (isset($data['data']['sizes']) && is_array($data['data']['sizes'])) {
            $data['data']['sizes'] = json_encode($data['data']['sizes']);
        }
        return $data;
    }
}