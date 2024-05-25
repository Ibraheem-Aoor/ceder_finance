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

@push('script-page')
    <style>
        .w-200 {
            width: 200px !important;
        }
    </style>
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
                                    <th> {{ __('role') }}</th>
                                    <th> {{ __('start_date') }}</th>
                                    <th> {{ __('end_date') }}</th>
                                    <th> {{ __('salary') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $k => $employee)
                                    <tr class="cust_tr" id="cust_detail"
                                        data-url="{{ route('hr.employee.show', $employee['id']) }}"
                                        data-id="{{ $employee['id'] }}">
                                        <td class="Id">
                                            {{ $auth_user->employeeNumberFormat($employee->id) }}
                                        </td>
                                        <td class="font-style">{{ $employee['first_name'] }} {{ $employee['last_name'] }}
                                        </td>
                                        <td>{{ $employee['phone'] }}</td>
                                        <td>{{ $employee['role'] }}</td>
                                        <td>{{ $employee['start_date'] }}</td>
                                        <td>{{ $employee['end_date'] }}</td>
                                        <td>{{ $employee['salary'] }}</td>
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

@push('script-page')
    <script>
        console.log('S');
        $(document).on('click', '.week-navigate', function(e) {
            event.preventDefault();
            $('input[name="week_start"]').val($(this).data('week_start'));
            submitScheduleForm();
        });
        $(document).on('submit', '#schedule-form', function(e) {
            event.preventDefault();
            submitScheduleForm($(this).attr('action'));
        });
        // Form To Submit The Schedule
        function submitScheduleForm() {
            var form = $('#schedule-form');
            var url = form.attr('action');
            var formData = form.serialize();
            console.log(url);
            $.ajax({
                url: url,
                method: "PUT",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

                },
                success: function(response) {
                    if (response.status) {
                        show_toastr('Success', response.message, 'success');
                        $('#table-content').html(response.html);
                        if (response.location) {
                            $('input[name="location"]').val(response.location);
                        }
                        if (response.customer_id) {
                            $('select[name="customer"]').val(response.customer_id);
                        }

                    } else {
                        show_toastr('Error', response.message, 'error');
                    }
                },
                error: function(response) {
                    if (response.status == 422) {
                        $.each(response.responseJSON.errors, function(key, errorsArray) {
                            $.each(errorsArray, function(item, error) {
                                show_toastr('Error', error, 'error');
                            });
                        });
                    } else {
                        show_toastr('Error', response.message, 'error');
                    }
                }
            });
        }

    </script>
@endpush
