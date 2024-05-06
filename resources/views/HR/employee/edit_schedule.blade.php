<div class="card bg-none card-box">
    {{ Form::model($employee, ['route' => ['hr.employee.update_schedule', $employee->id], 'method' => 'PUT']) }}
    <h5 class="sub-title">{{ __('Basic Info') }}</h5>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('day', $today_name . ' (' . $today_date . ')  Working Hours', ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-clock"></i></span>
                    {{ Form::text('hours', @$today_work_hours, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <div class="form-icon-user">
                    <br>
                    <a class="btn btn-sm btn-primary t mt-2" href="{{ route('hr.employee.download_schedule' , $employee->id) }}"><i
                            class="fa fa-download"></i> &nbsp;{{ __('Download Working Report') }}</a>
                </div>
            </div>
        </div>



        <div class="col-md-12 px-0">
            <input type="submit" value="{{ __('Update') }}" class="btn-create badge-blue">
            <input type="button" value="{{ __('Cancel') }}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
        {{ Form::close() }}
    </div>
</div>
