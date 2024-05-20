{{ Form::model($employee, ['route' => ['hr.employee.update', $employee->id], 'method' => 'PUT']) }}
<div class="card bg-none card-box">
    <h5 class="sub-title">{{ __('Basic Info') }}</h5>
    <div class="row">
        {{-- Start Names "FIRST-LAST" --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('name', __('first_name'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-address-card"></i></span>
                    {{ Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('name', __('last_name'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-address-card"></i></span>
                    {{ Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- End Names "FIRST-LAST" --}}

        {{-- mobile DOB --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('dob', __('dob'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-calendar"></i></span>
                    {{ Form::text('dob', null, ['class' => 'form-control datepicker', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- mobile  --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('phone', __('phone'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-mobile"></i></span>
                    {{ Form::number('phone', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- email  --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('email', __('email'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-envelope"></i></span>
                    {{ Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- role  --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('role', __('role'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-hashtag"></i></span>
                    {{ Form::text('role', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('account_number', __('account_number'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-hashtag"></i></span>
                    {{ Form::text('account_number', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- Alias --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('alias', __('alias'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-address-card"></i></span>
                    {{ Form::text('alias', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- Legtimate Type --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('legitimation_type', __('legitimation_type'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fa fa-gavel"></i></span>
                    <select name="legitimation_type" id="legitimation_type" class="form-control text-center" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach ($legtemate_types as $type)
                            <option value="{{ $type->value }}" @if($employee->legitimation_type == $type->value) selected @endif >{{ __($type->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- Legtimate number --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('legitimation_number', __('legitimation_number'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-gavel"></i></span>
                    {{ Form::text('legitimation_number', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- BSN --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('bsn', __('bsn'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-file"></i></span>
                    {{ Form::text('bsn', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- valid_until --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('valid_until', __('valid_until'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-calendar"></i></span>
                    {{ Form::text('valid_until', null, ['class' => 'form-control datepicker', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- contract_date --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('contract_date', __('contract_date'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-calendar"></i></span>
                    {{ Form::text('contract_date', null, ['class' => 'form-control datepicker', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- start_date --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('start_date', __('start_date'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-calendar"></i></span>
                    {{ Form::text('start_date', null, ['class' => 'form-control datepicker', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- end_date --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('end_date', __('end_date'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-calendar"></i></span>
                    {{ Form::text('end_date', null, ['class' => 'form-control datepicker', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- salary --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('salary', __('salary'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-money-bill-wave-alt"></i></span>
                    {{ Form::number('salary', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{-- salary_payment --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('salary_payment', __('salary_payment'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fa fa-clock"></i></span>
                    <select name="salary_payment" id="salary_payment" class="form-control text-center" required>
                        <option value="">{{ __('select') }}</option>
                        @foreach ($salary_payment_phases as $phase)
                            <option value="{{ $phase->value }}" @if ($employee->salary_payment == $phase->value) selected @endif>
                                {{ __($phase->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- id file --}}
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
                {{ Form::label('id_file', __('upload_id_document'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fa fa-upload"></i></span>
                    {{ Form::file('id_file', null, ['class' => 'form-control']) }}

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 px-0">
        <input type="submit" value="{{ __('Update') }}" class="btn-create badge-blue">
        <input type="button" value="{{ __('Cancel') }}" class="btn-create bg-gray" data-dismiss="modal">
    </div>
</div>
{{ Form::close() }}
