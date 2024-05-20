<div class="card bg-none card-box">
    {{ Form::model($car_walk, ['route' => ['cars.distance.update', $car_walk->id], 'method' => 'PUT']) }}
    @csrf
    <h5 class="sub-title">{{ __('Basic Info') }}</h5>
    <div class="row">
        {{-- Car Select --}}
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('car', __('car'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fas fa-car"></i></span>
                    <select name="car" id="car" class="form-control text-center" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}" @if($car_walk->car_id == $car->id) selected @endif>
                                {{ __($car->trade_name) }} ({{ $car->license_plate }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- Customer Select --}}
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('customer', __('customer'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fas fa-address-card"></i></span>
                    <select name="customer" id="customer" class="form-control text-center" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @if($car_walk->customer_id == $customer->id) selected @endif>
                                {{ __($customer->name) }} ({{ $auth_user->customerNumberFormat($customer->id) }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- Employee Select --}}
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('employee', __('employee'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fas fa-user"></i></span>
                    <select name="employee" id="employee" class="form-control text-center" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @if($car_walk->employee_id == $employee->id) selected @endif>
                                {{ __($employee->name) }} ({{ $auth_user->employeeNumberFormat($employee->id) }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('date', __('date') . '(KM)', ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-clock"></i></span>
                    {{ Form::text('date', null, ['class' => 'form-control datepicker', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('walked_distance', __('walked_distance') . '(KM)', ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-map"></i></span>
                    {{ Form::number('walked_distance', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 px-0">
        <input type="submit" value="{{ __('Create') }}" class="btn-create badge-blue">
        <input type="button" value="{{ __('Cancel') }}" class="btn-create bg-gray" data-dismiss="modal">
    </div>

    {{ Form::close() }}
</div>
