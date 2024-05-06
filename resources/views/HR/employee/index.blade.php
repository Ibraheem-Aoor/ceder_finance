@extends('layouts.admin')
@php
    $profile = asset(Storage::url('uploads/avatar/'));
@endphp
@push('script-page')
    <script>
        $(document).on('click', '#billing_data', function() {
            $("[name='shipping_name']").val($("[name='billing_name']").val());
            $("[name='shipping_country']").val($("[name='billing_country']").val());
            $("[name='shipping_state']").val($("[name='billing_state']").val());
            $("[name='shipping_city']").val($("[name='billing_city']").val());
            $("[name='shipping_phone']").val($("[name='billing_phone']").val());
            $("[name='shipping_zip']").val($("[name='billing_zip']").val());
            $("[name='shipping_address']").val($("[name='billing_address']").val());
        })
    </script>
@endpush
@section('page-title')
    {{ __('Manage Employees') }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        {{-- @can('create employee') --}}
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-size="2xl" data-url="{{ route('hr.employee.create') }}" data-ajax-popup="true"
                data-title="{{ __('Create New Employee') }}"
                class="btn btn-xs btn-white btn-icon-only width-auto commonModal">
                <i class="fas fa-plus"></i> {{ __('Create') }}
            </a>
        </div>
        {{-- @endcan --}}
    </div>
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
                                    <th> {{ __('Name') }}</th>
                                    <th> {{ __('Mobile') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $k => $employee)
                                    <tr class="cust_tr" id="cust_detail"
                                        data-url="{{ route('hr.employee.show', $employee['id']) }}"
                                        data-id="{{ $employee['id'] }}">
                                        <td class="Id">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="font-style">{{ $employee['name'] }}</td>
                                        <td>{{ $employee['mobile'] }}</td>
                                        <td class="Action">
                                            <span>
                                                @if (getAuthUser('web')->is_active == 0)
                                                    <i class="fa fa-lock" title="Inactive"></i>
                                                @else
                                                    @can('edit employees')
                                                        <a href="#" class="edit-icon" data-size="2xl"
                                                            data-url="{{ route('hr.employee.edit', $employee['id']) }}"
                                                            data-ajax-popup="true" data-title="{{ __('Edit Employee') }}"
                                                            data-toggle="tooltip" data-original-title="{{ __('Edit') }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="#" class="edit-icon" data-size="2xl"
                                                            data-url="{{ route('hr.employee.edit_schedule', $employee['id']) }}"
                                                            data-ajax-popup="true" data-title="{{ __('Working Hours') }}"
                                                            data-toggle="tooltip" data-original-title="{{ __('Edit') }}">
                                                            <i class="fa fa-clock"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete employees')
                                                        <a href="#" class="delete-icon " data-toggle="tooltip"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $employee['id'] }}').submit();">
                                                            <i class="fas fa-trash"></i>
                                                        </a>

                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['hr.employee.destroy', $employee['id']],
                                                            'id' => 'delete-form-' . $employee['id'],
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @endif
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
