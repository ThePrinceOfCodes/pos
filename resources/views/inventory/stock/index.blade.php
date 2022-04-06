@extends('layouts.app', ['page' => 'Receipts', 'pageSlug' => 'stock', 'section' => 'inventory'])

@section('content')
    @include('alerts.success')
    <div class="row">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    {{-- <div class="col-8">
                        <h4 class="card-title">Receipts</h4>
                    </div> --}}
                    <div class="col-8">
                        <form class="form-inline" method="GET">

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
                    <div class="col-4 text-right">
                        <a href="{{ route('stock.create') }}" class="btn btn-sm btn-primary">Add to Stock</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table">
                        <thead>
                            <th>Date</th>
                            <th>Title</th>
                            <th>products</th>
                            <th>stock</th>
                            <th>Defective stock</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($stock as $receipt)
                                <tr>
                                    <td>{{ $receipt->created_at->toDayDateTimeString() }}</td>
                                    <td style="max-width:150px">{{ $receipt->title }}</td>

                                    <td>{{ $receipt->products->count() }}</td>
                                    <td>{{ $receipt->products->sum('stock') }}</td>
                                    <td>{{ $receipt->products->sum('stock_defective') }}</td>
                                    <td>
                                        @if($receipt->finalized_at)
                                            FINALIZED
                                        @else
                                            <span style="color:red; font-weight:bold;">TO FINALIZE</span>
                                        @endif
                                    </td>
                                    <td class="td-actions text-right">
                                        @if($receipt->finalized_at)
                                            <a href="{{ route('stock.show', ['stock' => $receipt]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Ver Receipt">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('stock.show', ['stock' => $receipt]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Receipt">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                        @endif
                                        @hasanyrole('Admin|Manager')
                                        <form action="{{ route('stock.destroy', $receipt) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Receipt" onclick="confirm('Estás seguro que quieres eliminar este recibo? Todos sus registros serán eliminados permanentemente, si ya está finalizado el stock de los productos permanecerán.') ? this.parentElement.submit() : ''">
                                                <i class="tim-icons icon-simple-remove"></i>
                                            </button>
                                        </form>
                                        @endhasrole
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $stock->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
