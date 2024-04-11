@extends('layouts.admin')
@section('page-title')
    {{__('Manage Budget Planner')}}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('create budget planner')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="{{ route('budget.create',0) }}" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-plus"></i> {{__('Create')}}
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
                                <th> {{__('Name')}}</th>
                                <th> {{__('From')}}</th>
                                <th> {{__('To')}}</th>
                                <th> {{__('Budget Period')}}</th>
                                <th> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($budgets as $budget)
                                <tr>
                                    <td class="font-style">{{ $budget->name }}</td>
                                    <td class="font-style">{{ $budget->from }}</td>
                                    <td class="font-style">{{ $budget->to }}</td>
                                    <td class="font-style">{{ __(\App\Models\Budget::$period[$budget->period]) }}</td>
                                    <td class="Action">
                                        <span>
                                            @can('edit budget planner')
                                                <a href="{{ route('budget.edit',Crypt::encrypt($budget->id)) }}" class="edit-icon" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('view budget planner')
                                                    <a href="{{ route('budget.show',\Crypt::encrypt($budget->id)) }}" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                        <i class="fas fa-eye"></i>
                                                        </a>
                                            @endcan
                                            @can('delete budget planner')
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$budget->id}}').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['budget.destroy', $budget->id],'id'=>'delete-form-'.$budget->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
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
