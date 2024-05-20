@extends('layouts.admin')
@section('page-title')
    {{ __('Manage cars') }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('create car')
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-size="2xl" data-url="{{ route('cars.create') }}" data-ajax-popup="true"
                data-title="{{ __('Create New car') }}"
                class="btn btn-xs btn-white btn-icon-only width-auto commonModal">
                <i class="fas fa-plus"></i> {{ __('Create') }}
            </a>
        </div>
        @endcan
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
                                    <th> {{ __('Image') }}</th>
                                    <th> {{ __('Name') }}</th>
                                    <th> {{ __('color') }}</th>
                                    <th> {{ __('license_plate') }}</th>
                                    <th> {{ __('walked_distance') }}</th>
                                    <th> {{ __('brand') }}</th>
                                    <th> {{ __('fuel') }}</th>
                                    {{-- <th> {{ __('Action') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cars as $k => $car)
                                    <tr class="cust_tr" id="cust_detail"
                                        data-url="{{ route('cars.show', $car['id']) }}"
                                        data-id="{{ $car['id'] }}">
                                        <td class="Id">
                                            {{ $loop->index+1 }}
                                        </td>
                                        <td><img src="{{ $car['extra_data']['ImageUrl'] }}" alt="$car['trade_name']" width="200"></td>
                                        <td class="font-style">{{ $car['trade_name'] }}
                                        </td>
                                        <td>{{ $car['color'] }}</td>
                                        <td class="text-success">{{ $car['license_plate'] }}</td>
                                        <td class="text-success">{{ $car['walked_distance'] + $car->walks()->sum('walked_distance') }}</td>
                                        <td>{{ $car['brand']->name }}</td>
                                        <td>{{ $car['fuel']->name }}</td>
                                        {{-- <td class="Action">
                                            <span>
                                                @if (getAuthUser('web')->is_active == 0)
                                                    <i class="fa fa-lock" title="Inactive"></i>
                                                @else
                                                    @can('edit car')
                                                        <a href="#" class="edit-icon" data-size="2xl"
                                                            data-url="{{ route('cars.edit', $car['id']) }}"
                                                            data-ajax-popup="true" data-title="{{ __('Edit car') }}"
                                                            data-toggle="tooltip" data-original-title="{{ __('Edit') }}">
                                                            <i class="fas fa-car"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete car')
                                                        <a href="#" class="delete-icon " data-toggle="tooltip"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $car['id'] }}').submit();">
                                                            <i class="fas fa-trash"></i>
                                                        </a>

                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['cars.destroy', $car['id']],
                                                            'id' => 'delete-form-' . $car['id'],
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @endif
                                            </span>
                                        </td> --}}
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
        $(document).on('click', '.week-navigate', function(e) {
            event.preventDefault();
            $('input[name="week_start"]').val($(this).data('week_start'));
            submitScheduleForm();
        });
        $(document).on('submit' , '#schedule-form' , function(e){
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
                        if(response.location)
                        {
                            $('input[name="location"]').val(response.location);
                        }
                        if(response.customer_id)
                        {
                            $('select[name="customer"]').val(response.customer_id);
                        }

                        calculateTotal();
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
    <script>
        $('#commonModal').on('shown.bs.modal' , function(){
            calculateTotal();
        });
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();

            document.querySelectorAll('input[name^="hours"]').forEach(function(input) {
                input.addEventListener('input', calculateTotal);
            });
        });

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('input[name^="hours"]').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('total-hours').innerText = total.toFixed(2);
        }
    </script>
@endpush
