<div class="card bg-none card-box">
    {{ Form::open(['url' => 'HR/employee', 'method' => 'post']) }}
    @csrf
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

        {{-- mobile Optional Field --}}
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('mobile', __('mobile'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fa fa-mobile"></i></span>
                    {{ Form::text('mobile', null, ['class' => 'form-control' , 'required' => 'required']) }}
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
