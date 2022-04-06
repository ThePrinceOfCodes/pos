<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'product' => ProductResource::make($this->product),
            'quantity' => $this->qty,
            'price' => $this->price,
            'total' => $this->total_amount,
            'payment_method' => PaymentTypeResource::make($this->paymentMethod),
            'reference' => $this->txref
        ];
    }
}
