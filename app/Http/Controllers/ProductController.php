<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Cart_item;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request){
        $value = empty($request->input('price'))?'0':$request->input('price') ;

        $all = DB::select(DB::raw("select * from products where precio > $value"));

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($all);
        $perPage = 2;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $productos= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $productos->setPath($request->url());

        return view('products')->with('products',$productos);
    }

    public function addToCart($id){

        $product = Product::find($id);

        Log::error('error' . $id);
        Log::warning('warning' . $id);
        Log::notice('notice' . $id);
        Log::info('info' . $id);
        Log::debug('debug' . $id);

        Log::channel('suspicious')->info('Ejemplo log');
        Log::channel('single')->info('Ejemplo log');

        $user = Auth::user()->id;
        $cart_db = Cart::where("user_id",$user)->first();
        if ( empty($cart_db) ){
            $cart_db = new Cart();
            $cart_db->user_id = $user;
            $cart_db->save();
        }
        if(!$product) {
            abort(404);
        }
        $cart = session()->get('cart');

        if(!$cart) {
            $cart = [
                $id => [
                    "nombre" => $product->nombre,
                    "cantidad" => 1,
                    "precio" => $product->precio,
                    "image" => $product->image ]
            ];
            $cart_item = new Cart_Item();
            $cart_item->cart_id=$cart_db->id;
            $cart_item->product_id=$id;
            $cart_item->cantidad=1;
            $cart_item->save();
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        if(isset($cart[$id])) {
            $cart[$id]['cantidad']++;
            $cart_item = Cart_Item::where([
                ['cart_id',$cart_db->id],
                ['product_id',$id],
            ])->first();
            $cart_item->cantidad=$cart[$id]['cantidad'];
            $cart_item->update();
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        $cart[$id] = [
            "nombre" => $product->nombre,
            "cantidad" => 1,
            "precio" => $product->precio,
            "image" => $product->image
        ];
        $cart_item = new Cart_Item();
        $cart_item->cart_id=$cart_db->id;
        $cart_item->product_id=$id;
        $cart_item->cantidad=1;
        $cart_item->save();
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function cart()
    {
        return view('cart');
    }

    public function update(Request $request){


        if($request->id && $request->quantity){

            $cart = session()->get('cart');
            $cart[$request->id]["cantidad"] = $request->quantity;

            $user = Auth::user()->id;
            $cart_db = Cart::where("user_id",$user)->first();
            $cart_item = Cart_Item::where([
                ['cart_id',$cart_db->id],
                ['product_id',$request->id],
            ])->first();
            error_log('--------------------------' . $cart_db->id . '####'. $request->quantity);
            $cart_item->cantidad=$request->quantity;
            $cart_item->update();
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                $user = Auth::user()->id;
                $cart_db = Cart::where("user_id", $user)->first();
                $cart_item = Cart_Item::where([
                    ['cart_id', $cart_db->id],
                    ['product_id', $request->id],
                ])->first();
                $cart_item->delete();
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}
