<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\City;
use App\Services\CartService;
use Illuminate\Http\Request;
use App\Models\Province;
use Illuminate\Support\Facades\Http;
class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCartItems(auth()->id());
        $provinces = Province::all();

        return view('web.cart.index', compact('cartItems', 'provinces'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'qty' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();
        $book = Book::findOrFail($request->book_id);
        $quantity = $request->qty;
        $price = $book->price;
        $bookImage = $book->images->first() ? $book->images->first()->image : 'https://via.placeholder.com/450x450?text=No+Image';
        $weight = $book->weight ?? 1; // Default weight 1 kg

        $this->cartService->addToCart($userId, $book->id, $quantity, $price, $bookImage, $weight);

        return redirect()->route('cart.index')->with('success', 'Book added to cart!');
    }



    public function deleteCartItem($book_id)
    {
        $userId = auth()->id();

        if ($this->cartService->removeItemFromCart($userId, $book_id)) {
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        return redirect()->back()->with('error', 'Item not found in your cart.');
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->province_id;

        if (!$provinceId) {
            return response()->json(['error' => 'Province ID is required'], 400);
        }

        $cities = City::where('province_id', $provinceId)->get(['id', 'name']);
        return response()->json($cities);
    }

    public function getShippingCost(Request $request)
    {
        $request->validate([
            'destination' => 'required|exists:cities,id',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => config('rajaongkir.origin_city_id'), // ID kota asal (misal: Yogyakarta)
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch shipping cost'], 500);
        }

        $results = $response->json()['rajaongkir']['results'];
        return response()->json($results);
    }

}