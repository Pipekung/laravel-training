<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $waiting_amount = Product::select('amount')->where('status', '=', 'Waiting')->sum('amount');
        $processing_amount = Product::select('amount')->where('status', '=', 'Processing')->sum('amount');
        $instock_amount = Product::select('amount')->where('status', '=', 'In Stock')->sum('amount');
        $waiting_price = Product::select(DB::raw('price * amount as price'))->where('status', '=', 'Waiting')->get();
        $waiting_price_sum = 0;
        foreach($waiting_price as $v) {
            $waiting_price_sum += $v->price;
        }
        $processing_price = Product::select(DB::raw('price * amount as price'))->where('status', '=', 'Processing')->get();
        $processing_price_sum = 0;
        foreach($processing_price as $v) {
            $processing_price_sum += $v->price;
        }
        $instock_price = Product::select(DB::raw('price * amount as price'))->where('status', '=', 'In Stock')->get();
        $instock_price_sum = 0;
        foreach($instock_price as $v) {
            $instock_price_sum += $v->price;
        }
        return view('product/index', [
            'products' => $products,
            'waiting_amount' => $waiting_amount,
            'processing_amount' => $processing_amount,
            'instock_amount' => $instock_amount,
            'waiting_price' => $waiting_price_sum,
            'processing_price' => $processing_price_sum,
            'instock_price' => $instock_price_sum,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'amount' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required',
        ]);
        Product::create($validatedData);

        return redirect('/product')->with('success', 'Product is successfully saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product/edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'amount' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required',
        ]);
        Product::where('id', '=', $id)->update($validatedData);

        return redirect('/product')->with('success', 'Product is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/product')->with('success', 'Product is successfully deleted.');
    }
}
