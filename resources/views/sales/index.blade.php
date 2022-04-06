@extends('layouts.app', ['page' => 'Sales', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
    @include('alerts.success')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        {{-- <div class="col-8">
                            <h4 class="card-title">Sales</h4>
                        </div> --}}
                        <div class="col-10 text-center">
                            <form class="form-inline" method="GET" action="{{ route('sales.index') }}">
                                <div class="form-group">
                                    <label for="filter" class="col-sm-4 col-form-label">Cashier</label>
                                    <select name="user_id" class="form-select form-control">
                                        <option value="*" default selected>Select Cashier</option>
                                        @foreach ($cashiers as $cashier)
                                        <option value="{{$cashier->id}}" selected>{{$cashier->name }} </option>
                                        @endforeach
                                    </select>
                                  </div>

                                <div class="form-group">
                                  <label for="filter" class="col-sm-3 col-form-label">Start Date</label>
                                  <input type="date" class="form-control" name="created_at[start]" value="{{ $start_date }}">
                                </div>
                                <div class="form-group">
                                    <label for="filter" class="col-sm-3 col-form-label">End Date</label>
                                    <input type="date" class="form-control" name="created_at[end]" value="{{ $end_date }}" format="y-m-d">
                                </div>
                                <button type="submit" class="btn btn-default btn-sm">Filter</button>
                              </form>
                        </div>
                        <div class="col-2 text-right">
                           @hasrole('Developer|Admin|Cashier') <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary">Register Sale</a>@endrole
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                                <th>Date</th>
                                <th>Client</th>
                                <th>User</th>
                                <th>Products</th>
                                <th>Total Qty</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->created_at->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ route('clients.show', $sale->client) }}">{{ $sale->client->name }}</a>
                                        </td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td>{{ $sale->products->count() }}</td>
                                        <td>{{ $sale->products->sum('qty') }}</td>
                                        <td>{{ format_money($sale->products->sum('total_amount'))}}</td>
                                        <td>
                                            @if (!$sale->finalized_at)
                                                <span class="text-danger">To Finalize</span>
                                            @else
                                                <span class="text-success">Finalized</span>
                                            @endif
                                        </td>
                                        <td class="td-actions text-right">
                                            @if (!$sale->finalized_at)
                                                <a href="{{ route('sales.show', ['sale' => $sale]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Sale">
                                                    <i class="tim-icons icon-pencil"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('sales.show', ['sale' => $sale]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="View Sale">
                                                    <i class="tim-icons icon-zoom-split"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('sales.destroy', $sale) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Sale" onclick="confirm('Are you sure you want to delete this sale? All your records will be permanently deleted.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $sales->links() }}
                    </nav>
                </div>
            </div>
        </div>
        
    </div>
@endsection
