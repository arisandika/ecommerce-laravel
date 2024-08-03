<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;

class FrontController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('visibility', '0')->get();
        $categories = Category::where('visibility', '0')->with('products')->get();
        $products = Product::where('visibility', '0')->get();

        return view('front.home', compact('sliders', 'categories', 'products'));
    }

    public function allProducts()
    {
        return view('front.product.all-products');
    }

    public function categories()
    {
        $categories = Category::where('visibility', '0')
            ->where('slug', '<>', 'categories')
            ->get();
        return view('front.category.index', compact('categories'));
    }

    public function products($category_slug)
    {
        $category = Category::where('slug', $category_slug)->where('visibility', '0')->firstOrFail();
        return view('front.product.index', compact('category'));
    }

    public function singleProduct(string $category_slug, string $product_slug)
    {
        $category = Category::where('slug', $category_slug)->where('visibility', '0')->firstOrFail();
        $product = $category->products()->where('slug', $product_slug)->where('visibility', '0')->firstOrFail();
        return view('front.product.single-product', compact('category', 'product'));
    }

    public function checkoutPaynow($orderId)
    {
        $order = Order::where('id', $orderId)->where('status_order', 'Pending')->where('user_id', auth()->user()->id)->firstOrFail();
        return view('front.checkout.checkout-paynow', compact('order'));
    }
    
    public function checkoutSuccess($orderId)
    {
        $order = Order::where('id', $orderId)->where('status_order', 'Pending')->where('user_id', auth()->user()->id)->firstOrFail();
        $order->status_order = 'Paid Success';
        $order->save();
        
        return view('front.checkout.checkout-success', compact('order'));
    }
    
    public function showOrders()
    {
        $orders = Order::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('front.order.index', compact('orders'));
    }
    
    public function showOrdersDetails($orderId)
    {
        $order = Order::where('user_id', auth()->user()->id)->where('id', $orderId)->first();

        if ($order) {
            return view('front.order.order-detail', compact('order'));
        }

        return redirect()->back();
    }
    
    public function accountPage()
    {
        $orders = Order::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('front.account.index', compact('orders'));
    }
}