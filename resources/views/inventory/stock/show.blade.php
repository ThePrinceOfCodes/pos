@extends('layouts.app', ['page' => 'Manage Receipt', 'pageSlug' => 'stock', 'section' => 'inventory'])


@section('content')
    @include('alerts.success')
    @include('alerts.error')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Stock Summary</h4>
                        </div>
                        @if (!$stock->finalized_at)
                            <div class="col-4 text-right">
                                @if ($stock->products->count() === 0)
                                    <form action="{{ route('stock.destroy', $stock) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Delete Stock
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-sm btn-primary" onclick="confirm('ATTENTION: At the end of this stock you will not be able to load more products in it.') ? window.location.replace('{{ route('stock.finalize', $stock) }}') : ''">
                                        Finalize Stock
                                    </button>
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
                            <th>Title</th>
                            <th>User</th>
                            <th>products</th>
                            <th>Stock</th>
                            <th>Defective</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <tr>
                                {{-- <td>{{ $stock->id }}</td> --}}
                                <td>{{ $stock->created_at->toDayDateTimeString() }}</td>
                                <td style="max-width:150px;">{{ $stock->title }}</td>
                                <td>{{ $stock->user->name }}</td>

                                <td>{{ $stock->products->count() }}</td>
                                <td>{{ $stock->products->sum('stock') }}</td>
                                <td>{{ $stock->products->sum('stock_defective') }}</td>
                                <td>{!! $stock->finalized_at ? 'Finalized' : '<span style="color:red; font-weight:bold;">TO FINALIZE</span>' !!}</td>
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
                            <h4 class="card-title">products: {{ $stock->products->count() }}</h4>
                        </div>
                        @if (!$stock->finalized_at)
                            <div class="col-4 text-right">
                                <a href="{{ route('stock.product.add', ['stock' => $stock]) }}" class="btn btn-sm btn-primary">Add</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Defective</th>
                            <th>Total</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($stock->products as $received_product)
                                <tr>
                                    <td><a href="{{ route('categories.show', $received_product->product->category) }}">{{ $received_product->product->category->name }}</a></td>
                                    <td><a href="{{ route('products.show', $received_product->product) }}">{{ $received_product->product->name }}</a></td>
                                    <td>{{ $received_product->stock }}</td>
                                    <td>{{ $received_product->stock_defective }}</td>
                                    <td>{{ $received_product->stock + $received_product->stock_defective }}</td>
                                    <td class="td-actions text-right">
                                        @if(!$stock->finalized_at)
                                            <a href="{{ route('stock.product.edit', ['stock' => $stock, 'receivedproduct' => $received_product]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Pedido">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('stock.product.destroy', ['stock' => $stock, 'receivedproduct' => $received_product]) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Pedido" onclick="confirm('Estás seguro que quieres eliminar este producto?') ? this.parentElement.submit() : ''">
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
