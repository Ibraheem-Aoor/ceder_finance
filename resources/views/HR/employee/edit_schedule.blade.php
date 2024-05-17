<div class="card bg-none card-box">
    {{ Form::model($employee, ['route' => ['hr.employee.update_schedule', $employee->id], 'method' => 'PUT', 'id' => 'schedule-form']) }}
    <h5 class="sub-title">{{ __('Basic Info') }}</h5>
    <a class="btn btn-sm btn-primary t mt-2" href="{{ route('hr.employee.download_schedule', $employee->id) }}">
        <i class="fa fa-download"></i> &nbsp;{{ __('Download Working Report') }}
    </a>
    <div class="row">
        {{-- Customer Select --}}
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('customer', __('Customer'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fas fa-user"></i></span>
                    <select name="customer" id="customer" class="form-control text-center" required>
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- Location --}}
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('location', __('location'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-map"></i></span>
                    {{ Form::text('location', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- Weeks TABLE --}}
        <div class="col-md-12 px-0" id="table-content">
            @include('HR.employee.weeks_table' , ['employee' => $employee , 'work_hours' => $work_hours])
        </div>

        {{ Form::close() }}
    </div>
</div>
