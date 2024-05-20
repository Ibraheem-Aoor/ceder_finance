<div class="card bg-none card-box">
    <form action="" enctype="multipart/form-data"></form>
    {{ Form::open(['url' => 'cars', 'method' => 'post']) }}
    @csrf
    <h5 class="sub-title">{{ __('Basic Info') }}</h5>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('license_plate', __('license_plate'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-car"></i></span>
                    {{ Form::text('license_plate', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('walked_distance', __('walked_distance') ."(KM)", ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-car"></i></span>
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
