<?php

namespace App\Libraries;

/**
 * Basic custom cart implementation.
 * You will need to expand this class with actual cart logic (add, remove, update quantities, persist to session/database, etc.)
 */
class MyCart
{
    // A property to hold cart items (for a simple in-memory representation)
    protected array $items = [];

    public function __construct()
    {
        // Constructor for your custom cart.
        // You might later load cart items from the session or a database here.
    }

    /**
     * Returns the contents of the cart.
     * For now, returns an empty array to prevent errors in the view if the cart is empty.
     */
    public function contents(): array
    {
        // In a real application, this would return the actual items in the cart.
        // Example structure for a cart item (as expected by cart.php):
        // (object)[
        //     'id'        => 'product_id',
        //     'qty'       => 1,
        //     'price'     => 100.00,
        //     'name'      => 'Product Name',
        //     'options'   => [],
        //     'product'   => ['id' => 'product_id', 'name' => 'Product Name', 'price' => 100.00, 'image' => 'product.jpg', 'stock' => 10],
        //     'itemTotal' => 100.00
        // ]
        return $this->items;
    }

    /**
     * Returns the total value of items in the cart.
     * For now, returns 0.00.
     */
    public function total(): float
    {
        // In a real application, this would calculate the sum of all item totals.
        $total = 0.00;
        foreach ($this->items as $item) {
            $total += $item->itemTotal ?? 0;
        }
        return $total;
    }

    /**
     * Returns the total number of items (quantity) in the cart.
     * This method is required by CheckoutController.php at line 11.
     */
    public function totalItems(): int
    {
        $totalQty = 0;
        foreach ($this->items as $item) {
            $totalQty += $item->qty ?? 0; // Summing the 'qty' property of each item
        }
        return $totalQty;
    }

    /**
     * Placeholder for adding items to the cart.
     * You will need to implement the actual logic for adding products.
     */
    public function insert(array $itemData): void
    {
        // Example of how you might add an item.
        // This is very basic and needs proper implementation.
        $this->items[$itemData['id']] = (object) [
            'id'        => $itemData['id'],
            'qty'       => $itemData['qty'] ?? 1,
            'price'     => $itemData['price'],
            'name'      => $itemData['name'],
            'options'   => $itemData['options'] ?? [],
            'product'   => $itemData['product'] ?? ['name' => $itemData['name'], 'price' => $itemData['price'], 'image' => 'default.jpg'], // Mimic product structure
            'itemTotal' => ($itemData['qty'] ?? 1) * $itemData['price'],
        ];
    }

    /**
     * Placeholder for removing items from the cart.
     * You will need to implement the actual logic.
     */
    public function remove(string $rowId): void
    {
        unset($this->items[$rowId]);
    }

    // You would add more methods here like 'update', 'destroy', etc. as your cart functionality grows.
}