<div class="card bg-none card-box">
    {{ Form::model($employee, ['route' => ['hr.employee.update', $employee->id], 'method' => 'PUT']) }}
    <h5 class="sub-title">{{ __('Basic Info') }}</h5>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-address-card"></i></span>
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>

        {{-- Mobile Optional Field --}}
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('mobile', __('mobile'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-file"></i></span>
                    {{ Form::text('mobile', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>


    <div class="col-md-12 px-0">
        <input type="submit" value="{{ __('Update') }}" class="btn-create badge-blue">
        <input type="button" value="{{ __('Cancel') }}" class="btn-create bg-gray" data-dismiss="modal">
    </div>
    {{ Form::close() }}
</div>
