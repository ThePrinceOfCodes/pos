<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PaymentTypeResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SalesResource;
use App\PaymentMethod;
use App\Product;
use App\ProductCategory;
use App\Sale;
use App\SoldProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class CashierController extends Controller
{
    //
    public function getProducts() {

        $products = Product::where('stock', '>', 0)->get();

        // return $this->successResponse('Products fetched successfully', $products);
        return ProductResource::collection($products);
    }

    public function getCategories() {

        $categories = ProductCategory::all();

        // return $this->successResponse('Categories fetched successfully', $categories);
        return CategoryResource::collection($categories);
    }

    public function paymentMethods() {

        return PaymentTypeResource::collection(PaymentMethod::all());
    }

    public function getSales(Sale $sale) {

        if (!is_null($sale->finalized_at)) {
            # code...
            return $this->errorResponse("Shift Already closed for this sale");
        }

        $sales = $sale->products;

        return SalesResource::collection($sales);
    }

    public function makeSales(Request $request) {

        // return $request->toArray();
        $validator = Validator::make($request->all(), [
            // 'sale_id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price' => 'required',
            'items.*.qty' => 'required',
            'items.*.total_amount' => 'required',
            'payment_method' => 'required',
            'salesID' => 'required'
        ]);

        // return $request->toArray();
        $sale = Sale::find($request->salesID);

        // return $sale;

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        DB::beginTransaction();
        try {
            $txref = ['txref' => strtoupper(substr("ND", 0, 3)).date("-ymd").sprintf("%05d",SoldProduct::latest()->first()->id ?? 0)];

            foreach ($request->items as $item) {
                # code...
                $soldItem = $item += ['payment_method_id' => $request->payment_method];
                $soldItem = $item += $txref;
                // return $soldItem;
                $sale->products()->create($soldItem);
            }

            $this->finalize($sale);


            DB::commit();
        } catch (\Throwable $th) {

            DB::rollback();

            return "Opps Something went wrong";
        }

        return $this->successResponse("Sales recorded successfully", $txref);

    }

    public function closeShift(Sale $sale) {

        if (!is_null($sale->finalized_at)) {
            # code...
            return $this->errorResponse("Shift Already closed");
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();

        $sale->save();

        return $this->successResponse("Shift Closed");

    }

    public function finalize(Sale $sale)
    {
        $products = $sale->products->where('is_new', true);
        $sale->total_amount += $products->sum('total_amount');

        foreach ($products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->stock;
            if($sold_product->qty > $product_stock) {
                throw new \Exception("The product '$product_name' does not have enough stock. Only has $product_stock units.");
            }
        }

        foreach ($products as $sold_product) {
            $sold_product->product->stock -= $sold_product->qty;
            $sold_product->is_new = false;
            $sold_product->save();
            $sold_product->product->save();

        }
        $sale->client->balance -= $products->sum('total_amount');
        $sale->save();
        $sale->client->save();

        // return back()->withStatus('The sale has been successfully completed.');
    }

    public function organizationDetails() {
        return $this->successResponse("Fetched successfully!!", [
            "company_name" => "ND COMMUNICATIONS",
            "address" => " ",
            "phone_number" => "",
            'email' => "treasurebar@gmail.com"
        ]);
    }


}
