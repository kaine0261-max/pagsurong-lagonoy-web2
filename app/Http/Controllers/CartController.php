<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart items grouped by business
     */
    public function index()
    {
        $cartItems = Cart::with(['product.business'])
            ->where('user_id', Auth::id())
            ->get();

        // Group cart items by business
        $groupedCartItems = $cartItems->groupBy('product.business_id');

        return view('customer.cart', compact('groupedCartItems'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        // Get the product to access its price and stock
        $product = \App\Models\Product::findOrFail($validated['product_id']);

        // Check if product is out of stock
        if ($product->isOutOfStock()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'This product is currently out of stock!'], 400);
            }
            return redirect()->back()->with('error', 'This product is currently out of stock!');
        }

        // Check if requested quantity is available
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        $totalRequestedQuantity = $validated['quantity'];
        if ($existingCart) {
            $totalRequestedQuantity += $existingCart->quantity;
        }

        if ($totalRequestedQuantity > $product->current_stock) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => "Only {$product->current_stock} items available in stock!"], 400);
            }
            return redirect()->back()->with('error', "Only {$product->current_stock} items available in stock!");
        }

        if ($existingCart) {
            $existingCart->update([
                'quantity' => $existingCart->quantity + $validated['quantity']
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
                'business_id' => $product->business_id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);
        }

        // Get updated cart count
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Product added to cart!', 'cartCount' => $cartCount]);
        }
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock availability
        $product = $cart->product;
        if ($request->quantity > $product->current_stock) {
            return redirect()->back()->with('error', "Only {$product->current_stock} items available in stock!");
        }

        $cart->update($request->only('quantity'));

        return redirect()->back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Cart cleared!');
    }

    /**
     * Clear cart items for a specific business
     */
    public function clearByBusiness($businessId)
    {
        Cart::where('user_id', Auth::id())
            ->where('business_id', $businessId)
            ->delete();

        return redirect()->back()->with('success', 'Cart items cleared for this business!');
    }
}