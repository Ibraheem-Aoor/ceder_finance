@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Inboxes') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{ __('Invocie') }}</th>
                                    <th> {{ __('Date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inboxes as $k => $inbox)
                                    <tr class="cust_tr">
                                        <td class="Id">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="font-style">
                                            <a href="{{ getImageUrl($inbox->path) }}">
                                                <img src="{{ getImageUrl($inbox->path) }}" width="200"
                                                >
                                            </a>
                                        </td>
                                        <td>{{ $inbox->created_at }}</td>
                                        <td class="Action">
                                            <span>
                                                <a href="{{ route('file.download' , ['file_path' => $inbox->path]) }}" class="btn btn-icon btn-sm btn-info">
                                                    <i class="fas fa-download"></i>
                                                </a>&nbsp;
                                                <a href="{{ getImageUrl($inbox->path) }}" class="btn btn-icon btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>&nbsp;
                                                <a href="#" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip"
                                                    data-original-title="{{ __('Delete') }}"
                                                    data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="document.getElementById('delete-form-{{ $inbox['id'] }}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['inbox.destroy', $inbox->id],
                                                    'id' => 'delete-form-' . $inbox->id,
                                                ]) !!}
                                                {!! Form::close() !!}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

