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
        $waiting_price = Product::select(DB::raw('price * amount as price'))->where('status', '=', 'Waiting')->first();
        $processing_price = Product::select(DB::raw('price * amount as price'))->where('status', '=', 'Processing')->first();
        $instock_price = Product::select(DB::raw('price * amount as price'))->where('status', '=', 'In Stock')->first();
        return view('product/index', [
            'products' => $products,
            'waiting_amount' => $waiting_amount,
            'processing_amount' => $processing_amount,
            'instock_amount' => $instock_amount,
            'waiting_price' => $waiting_price === null ? 0 : $waiting_price->price,
            'processing_price' => $processing_price === null ? 0 : $processing_price->price,
            'instock_price' => $instock_price === null ? 0 : $instock_price->price,
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
