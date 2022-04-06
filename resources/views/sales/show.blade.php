@extends('layouts.app', ['page' => 'Manage Sale', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
    @include('alerts.success')
    @include('alerts.error')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Sale Summary</h4>
                        </div>
                        @if (!$sale->finalized_at)
                            <div class="col-4 text-right">
                                @if ($sale->products->count() == 0)
                                    <form action="{{ route('sales.destroy', $sale) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Delete Sale
                                        </button>
                                    </form>
                                @else
                                @hasanyrole('Admin|Manager|Developer')
                                    <button type="button" class="btn btn-sm btn-primary" onclick="confirm('ATTENTION: Do you want to finalize it? Your records cannot be modified from now on.') ? window.location.replace('{{ route('sales.finalize', $sale) }}') : ''">
                                        Close Shift
                                    </button>
                                    @endhasanyrole
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            {{-- <th>ID</th> --}}
                            <th>Date</th>
                            <th>Cashier</th>
                            {{-- <th>Client</th> --}}
                            @foreach ($paymentMethods as $method)
                            <th>{{ $method->name }}</th>
                            @endforeach
                            <th>Total Amount</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <tr>
                                {{-- <td>{{ $sale->id }}</td> --}}
                                <td>{{ $sale->created_at->toDayDateTimeString() }}</td>
                                <td>{{ $sale->user->name }}</td>
                                {{-- <td><a href="{{ route('clients.show', $sale->client) }}">{{ $sale->client->name }}</a></td> --}}
                                @foreach ($paymentMethods as $method)
                                <td>{{ format_money($sale->products->where('payment_method_id', $method->id)->sum('total_amount')) }}</td>
                                @endforeach

                                <td>{{ format_money($sale->products->sum('total_amount')) }}</td>
                                <td>{!! $sale->finalized_at ? 'Completed at<br>'.date('d-m-y', strtotime($sale->finalized_at)) : (($sale->products->count() > 0) ? 'TO FINALIZE' : 'ON HOLD') !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">products: {{ $sale->products->count() }}</h4>
                        </div>
                        @if (!$sale->finalized_at)
                            <div class="col-4 text-right">
                                @hasrole('Cashier|Developer')
                                <a href="{{ route('sales.product.add', ['sale' => $sale->id]) }}" class="btn btn-sm btn-primary">Add</a>
                                @endhasrole
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Method</th>
                            <th>Total</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <input type="hidden" value="{{ $s= 0 }}">
                            @foreach ($sale->products as $sold_product)
                                <tr>
                                    <td>{{ ++$s }}</td>
                                    <td><a href="{{ route('categories.show', $sold_product->product->category) }}">{{ $sold_product->product->category->name }}</a></td>
                                    <td><a href="{{ route('products.show', $sold_product->product) }}">{{ $sold_product->product->name }}</a></td>
                                    <td>{{ $sold_product->qty }}</td>
                                    <td>{{ format_money($sold_product->price) }}</td>
                                    <td>{{ $sold_product->paymentMethod->name ?? "" }}</td>
                                    <td>{{ format_money($sold_product->total_amount) }}</td>
                                    <td class="td-actions text-right">
                                        @if(!$sale->finalized_at)
                                            <a href="{{ route('sales.product.edit', ['sale' => $sale, 'soldproduct' => $sold_product]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Product">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('sales.product.destroy', ['sale' => $sale, 'soldproduct' => $sold_product]) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Product" onclick="confirm('Are you sure you want to delete this product? This cannot be undone') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets') }}/js/sweetalerts2.js"></script>
@endpush
