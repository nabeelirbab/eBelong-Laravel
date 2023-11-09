<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('back-end.admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric',
            'expires_at' => 'nullable|date'
        ]);

        Coupon::create($request->all());

        Session::flash('message', 'Coupon created successfully.');
        return redirect()->back();
    }

    public function edit(Coupon $coupon)
    {
        return view('back-end.admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        // Validating the request data
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric',
            'expires_at' => 'nullable|date'
        ]);

        // Updating the coupon
        $coupon->update([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'expires_at' => $request->expires_at
        ]);

        // Redirecting with a success message
        Session::flash('message', 'Coupon updated successfully.');
        return redirect()->route('coupons.index');
    }

    public function show(Coupon $coupon)
    {
        // Delete the coupon
        $coupon->delete();

        // Redirect to the coupons index page with a success message
        Session::flash('message', 'Coupon deleted successfully.');
        return redirect()->route('coupons.index');
    }
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $originalAmountString = $request->input('original_amount');
        $originalAmount = floatval(preg_replace('/[^\d.]/', '', $originalAmountString));


        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon) {
            if ($coupon->type == 'fixed') {
                // For fixed amount coupons
                $discount = $coupon->value;
                $newAmount = $originalAmount - $discount;
            } elseif ($coupon->type == 'percentage') {
                // For percentage-based coupons
                $discount = ($originalAmount * $coupon->value) / 100;
                $newAmount = $originalAmount - $discount;
            }

            // Ensure new amount is not negative
            $newAmount = max($newAmount, 0);
            $encryptedAmount = Crypt::encrypt($newAmount);
            session()->put(['product_price' => $newAmount]);
            return response()->json([
                'success' => true,
                'originalAmount' => $originalAmount,
                'discount' => $discount,
                'encryptedAmount' => $encryptedAmount,
                'newAmount' => $newAmount
            ]);
        } else {
            return response()->json(['success' => false, 'error' => 'Invalid coupon code.']);
        }
    }
}
