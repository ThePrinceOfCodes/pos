<?php

namespace App\Http\Controllers;

use App\Product;
use App\Provider;
use App\Receipt;
use App\ReceivedProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stock = Receipt::where('is_store', false)->paginate(25);

        return view('inventory.stock.index', compact('stock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $providers = Provider::all();
        $today = "Stock Added";

        return view('inventory.stock.create', compact('providers', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Receipt $stock)
    {
        //
        $request->merge(['is_store' => false]);
        $stock = $stock->create($request->all());

        return redirect()
            ->route('stock.show', $stock)
            ->withStatus('Stock registered successfully, you can start adding the products belonging to it.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $stock)
    {
        //
        // dd($stock->toArray());
        return view('inventory.stock.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $stock)
    {
        //
        $stock->delete();

        return redirect()
            ->route('stock.index')
            ->withStatus('Stock successfully removed.');
    }


    public function finalize(Receipt $stock)
    {
        $stock->finalized_at = Carbon::now()->toDateTimeString();
        $stock->save();

        foreach($stock->products as $receivedproduct) {

            // Increase Stock Amount
            $receivedproduct->product->stock += $receivedproduct->stock;
            // $receivedproduct->product->stock_defective += $receivedproduct->stock_defective;

            // Decrease Stock amount
            $receivedproduct->product->store -= $receivedproduct->stock;
            // $receivedproduct->product->stock_defective += $receivedproduct->stock_defective;

            $receivedproduct->product->save();


        }

        return back()->withStatus('Stock successfully completed.');
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function addproduct(Receipt $stock)
    {
        $products = Product::all();

        return view('inventory.stock.addstock', compact('stock', 'products'));
    }

    /**
     * Add product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function storeproduct(Request $request, Receipt $stock, ReceivedProduct $receivedproduct)
    {

        $product = Product::find($request->product_id);

        Validator::make($request->all(), [
            "stock" => "required|numeric|max:$product->store"
        ])->validate();

        // return $product->toArray();
        $receivedproduct->create($request->all());

        return redirect()
            ->route('stock.show', $stock)
            ->withStatus('Product added successfully.');
    }

    /**
     * Editor product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function editproduct(Receipt $stock, ReceivedProduct $receivedproduct)
    {
        $products = Product::all();

        return view('inventory.stock.editproduct', compact('stock', 'receivedproduct', 'products'));
    }

    /**
     * Update product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function updateproduct(Request $request, Receipt $stock, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->update($request->all());

        return redirect()
            ->route('stock.show', $stock)
            ->withStatus('Product edited successfully.');
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroyproduct(Receipt $stock, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->delete();

        return redirect()
            ->route('stock.show', $stock)
            ->withStatus('Product removed successfully.');
    }
}
