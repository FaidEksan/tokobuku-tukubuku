<?php

namespace App\Services;

use App\Models\Cart;
use App\Traits\CartLogicTrait;

class CartService
{
    use CartLogicTrait;

    public function addToCart($userId, $bookId, $quantity, $price, $image, $weight = 1)
    {
        $cartItem = Cart::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->qty + $quantity;
            $this->updateCartQuantity($cartItem->id, $newQuantity, $price * $newQuantity, $weight);
        } else {
            $this->createCartItem($userId, $bookId, $quantity, $price, $image, $weight);
        }
    }

    public function getCartItems($userId)
    {
        return Cart::where('user_id', $userId)->get();
    }

    public function removeItemFromCart($userId, $bookId)
    {
        $cartItem = Cart::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return true;
        }

        return false;
    }
}