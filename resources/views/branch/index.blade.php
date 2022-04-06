@extends('layouts.app', ['page' => __('Branch Management'), 'pageSlug' => 'branches', 'section' => 'branches'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Branches') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('branches.create') }}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Address') }}</th>
                                <th scope="col">{{ __('Description') }}</th>
                                <th scope="col">{{ __('Creation Date') }}</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                    <tr>
                                        <td>{{ $branch->name }}</td>
                                        <td>{{ $branch->address }}</td>
                                        <td>{{ $branch->description }}</td>
                                        <td>{{ $branch->created_at }}</td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('branches.show', $branch) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom"
                                                title="More Details">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom"
                                                title="Edit branch">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            @if(!auth()->user()->hasRole('Staff'))
                                            <form action="{{ route('branches.destroy', $branch) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Branch"
                                                    onclick="return confirm('Deleting will delete all branch records') ? this.parentElement.submit() : ''">
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
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $branches->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
