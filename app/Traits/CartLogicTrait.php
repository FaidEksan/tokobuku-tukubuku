<?php

namespace App\Traits;

use App\Models\Cart;

trait CartLogicTrait
{
    /**
     * Create a new cart item.
     *
     * @param int $userId
     * @param int $bookId
     * @param int $quantity
     * @param int $price
     * @param string $image
     * @param int $weight
     * @return Cart
     */
    public function createCartItem($userId, $bookId, $quantity, $price, $image, $weight = 1)
    {
        return Cart::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'qty' => $quantity,
            'price' => $price,
            'book_image' => $image,
            'weight' => $weight, // Tambahkan kolom weight
        ]);
    }

    /**
     * Update the quantity and weight of an existing cart item.
     *
     * @param int $cartId
     * @param int $quantity
     * @param int $price
     * @param int|null $weight
     * @return void
     */
    public function updateCartQuantity($cartId, $quantity, $price, $weight = null)
    {
        $cart = Cart::find($cartId);
        $cart->qty = $quantity;
        $cart->price = $price;

        // Update weight if provided
        if ($weight !== null) {
            $cart->weight = $weight;
        }

        $cart->save();
    }
}