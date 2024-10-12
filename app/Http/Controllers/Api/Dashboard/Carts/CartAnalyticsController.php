<?php

namespace App\Http\Controllers\Api\Dashboard\Carts;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Mail\CartReminderMail;
use App\Models\Cart;
use App\Models\SpecialCartDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CartAnalyticsController extends Controller
{
    public function abandonedCarts()
    {


        // Retrieve carts based on the provided date range
        $carts = Cart::with(['user', 'productColorSize.productColor.product'])
            ->latest()
            ->get();

        $cartDetails = [];

        foreach ($carts as $cart) {
            $productColorSize = $cart->productColorSize;

            if ($productColorSize) {
                // Get the product details and user details
                $product = $productColorSize->productColor->product;
                $photos = $productColorSize->productColor->photos;
                $photo = json_decode($photos);
                $user = $cart->user;
                $price = $productColorSize->price;
                $quantity = $cart->quantity;
                $total = $price * $quantity;

                // Add the data to the array
                $cartDetails[] = [
                    'customer_name' => $user->name,
                    'phone_number' => $user->phone,
                    'email' => $user->email,
                    'product_name' => $product->getTranslation('name', app()->getLocale()),
                    'photo' =>  $photo[0],
                    'product_price' => $price,
                    'cart_abandoned_date' => $cart->updated_at->toDateString(),
                    'product_quantity' => $quantity,
                    'total' => $total,
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'cart_details' => $cartDetails, // Return cart details with the response
        ]);
    }
    public function remindCart(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'end_time' => 'nullable|date|after:now',
        ]);

        // Check if the request has a discount and update or create it
        if ($request->hasAny(['discount_percentage', 'discount_amount'])) {
            // Delete any existing discount for this cart
            SpecialCartDiscount::where('cart_id', $id)->delete();

            // Create a new special discount
            SpecialCartDiscount::create([
                'cart_id' => $id,
                'discount_percentage' => $request->discount_percentage ?? null,
                'discount_amount' => $request->discount_amount ?? null,
                'end_time' => $request->end_time ?? null,
            ]);
        }

        // Find the cart with the user and product details
        $cart = Cart::with(['user', 'productColorSize.productColor.product', 'specialDiscounts'])
                    ->findOrFail($id);
        $productColorSize = $cart->productColorSize;

        if ($productColorSize) {
            $product = $productColorSize->productColor->product;
            $photos = $productColorSize->productColor->photos;
            $photo = json_decode($photos);
            $user = $cart->user;
            $price = $productColorSize->price;
            $quantity = $cart->quantity;
            $total = $price * $quantity;

            $discount = $cart->specialDiscounts->first();
            if ($discount) {
                if ($discount->discount_amount) {
                    $total = $total - $discount->discount_amount;
                } elseif ($discount->discount_percentage) {
                    $total = $total - ($total * ($discount->discount_percentage / 100));
                }
            }

            // Prepare cart details for the email
            $cartDetails = [
                'customer_name' => $user->name,
                'phone_number' => $user->phone,
                'email' => $user->email,
                'product_name' => $product->getTranslation('name', app()->getLocale()),
                'photo' => $photo[0],
                'product_price' => $price,
                'cart_abandoned_date' => $cart->updated_at->toDateString(),
                'product_quantity' => $quantity,
                'total' => $total,
                'discount_percentage' => $discount->discount_percentage ?? null,
                'discount_amount' => $discount->discount_amount ?? null,
            ];

            // Send the reminder email with discount (if applicable)
            Mail::to($user->email)->send(new CartReminderMail($cartDetails));

            // Mark the cart as reminded
            $cart->reminder = 1;
            $cart->save();

            return response()->json([
                'status' => 'success',
                'cart_details' => $cartDetails,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Product color size not found.'
        ], 404);
    }


    public function remindedCarts()
    {


        // Retrieve carts based on the provided date range
        $carts = Cart::with(['user', 'productColorSize.productColor.product'])
            ->where('reminder', 1)
            ->latest()
            ->get();

        $cartDetails = [];

        foreach ($carts as $cart) {
            $productColorSize = $cart->productColorSize;

            if ($productColorSize) {
                // Get the product details and user details
                $product = $productColorSize->productColor->product;
                $photos = $productColorSize->productColor->photos;
                $photo = json_decode($photos);
                $user = $cart->user;
                $price = $productColorSize->price;
                $quantity = $cart->quantity;
                $total = $price * $quantity;
                $discount = $cart->specialDiscounts->first();
                if ($discount) {
                    if ($discount->discount_amount) {
                        $total = $total - $discount->discount_amount;
                    } elseif ($discount->discount_percentage) {
                        $total = $total - ($total * ($discount->discount_percentage / 100));
                    }
                }

                // Add the data to the array
                $cartDetails[] = [
                    'customer_name' => $user->name,
                    'phone_number' => $user->phone,
                    'email' => $user->email,
                    'product_name' => $product->getTranslation('name', app()->getLocale()),
                    'photo' =>  $photo[0],
                    'product_price' => $price,
                    'cart_abandoned_date' => $cart->updated_at->toDateString(),
                    'product_quantity' => $quantity,
                    'total' => $total,
                    'discount_percentage' => $discount->discount_percentage ?? null,
                    'discount_amount' => $discount->discount_amount ?? null,

                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'cart_details' => $cartDetails, // Return cart details with the response
        ]);
    }
    public function notRemindedCarts()
    {


        // Retrieve carts based on the provided date range
        $carts = Cart::with(['user', 'productColorSize.productColor.product'])
            ->where('reminder', 0)
            ->latest()
            ->get();

        $cartDetails = [];

        foreach ($carts as $cart) {
            $productColorSize = $cart->productColorSize;

            if ($productColorSize) {
                // Get the product details and user details
                $product = $productColorSize->productColor->product;
                $photos = $productColorSize->productColor->photos;
                $photo = json_decode($photos);
                $user = $cart->user;
                $price = $productColorSize->price;
                $quantity = $cart->quantity;
                $total = $price * $quantity;

                // Add the data to the array
                $cartDetails[] = [
                    'customer_name' => $user->name,
                    'phone_number' => $user->phone,
                    'email' => $user->email,
                    'product_name' => $product->getTranslation('name', app()->getLocale()),
                    'photo' =>  $photo[0],
                    'product_price' => $price,
                    'cart_abandoned_date' => $cart->updated_at->toDateString(),
                    'product_quantity' => $quantity,
                    'total' => $total,
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'cart_details' => $cartDetails, // Return cart details with the response
        ]);
    }
}
