<?php

namespace App\Http\Controllers;

use App\Enums\EmployeeLegtemationTypeEnum;
use App\Enums\EmployeSalarayPaymentPhaseEnum;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BillExport;
use App\Exports\WeeklyReportsExport;
use App\Http\Requests\Company\EmployeeWorkHoursRequest;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarFuel;
use App\Models\CarWalk;
use App\Models\Employee;
use App\Models\EmployeeWorkHours;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Throwable;

class CarDistanceController extends Controller
{
    public function __construct()
    {
        $this->view = 'cars.distance.';
        $this->route = 'cars.distance.';
    }


    public function index(Request $request)
    {
        if (Auth::user()->can('view car')) {
            $data['cars_walks'] = CarWalk::query()
                ->with(['car:id,trade_name,license_plate,extra_data', 'employee:id,first_name,last_name', 'customer:id,name'])
                ->latest()
                ->get();
            $data['auth_user'] = getAuthUser();
            return view("{$this->view}.index", $data);
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {

        if (Auth::user()->can('create car')) {
            $auth_user = getAuthUser('web');
            $data['customers'] = Customer::query()->createdBy($auth_user->creatorId())->get(['id', 'name']);
            $data['employees'] = Employee::query()->createdBy($auth_user->creatorId())->get(['id', 'first_name', 'last_name']);
            $data['cars'] = Car::query()->createdBy($auth_user->creatorId())->get(['id', 'trade_name', 'license_plate']);
            $data['auth_user'] = $auth_user;
            return view("{$this->view}.create", $data);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('create car')) {
            try {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'car' => 'required|exists:cars,id',
                        'customer' => 'required|exists:customers,id',
                        'employee' => 'required|exists:employees,id',
                        'date' => 'required|date',
                        'walked_distance' => 'required|numeric',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->route($this->route . '.index')->with('error', $messages->first());
                }
                CarWalk::query()->create([
                    'car_id' => $request->car,
                    'customer_id' => $request->customer,
                    'employee_id' => $request->employee,
                    'date' => $request->date,
                    'walked_distance' => $request->walked_distance,
                ]);
                return redirect()->route($this->route . 'index')->with('success', __('Employee Created Successfully'));
            } catch (Throwable $e) {
                info('ERROR IN ' . __METHOD__ . ' || MESSSAGE:' . $e->getMessage());
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(CarWalk $distance)
    {

        if (Auth::user()->can('edit car')) {
            $auth_user = getAuthUser('web');
            $data['customers'] = Customer::query()->createdBy($auth_user->creatorId())->get(['id', 'name']);
            $data['employees'] = Employee::query()->createdBy($auth_user->creatorId())->get(['id', 'first_name', 'last_name']);
            $data['cars'] = Car::query()->createdBy($auth_user->creatorId())->get(['id', 'trade_name', 'license_plate']);
            $data['auth_user'] = $auth_user;
            $data['car_walk'] = $distance;
            return view("{$this->view}.edit", $data);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    public function update(Request $request , CarWalk $distance)
    {
        if (Auth::user()->can('edit car')) {
            try {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'car' => 'required|exists:cars,id',
                        'customer' => 'required|exists:customers,id',
                        'employee' => 'required|exists:employees,id',
                        'date' => 'required|date',
                        'walked_distance' => 'required|numeric',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->route($this->route . '.index')->with('error', $messages->first());
                }
                $distance->update([
                    'car_id' => $request->car,
                    'customer_id' => $request->customer,
                    'employee_id' => $request->employee,
                    'date' => $request->date,
                    'walked_distance' => $request->walked_distance,
                ]);
                return redirect()->route($this->route . 'index')->with('success', __('Updated Successfully'));
            } catch (Throwable $e) {
                info('ERROR IN ' . __METHOD__ . ' || MESSSAGE:' . $e->getMessage());
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }




    public function destroy(CarWalk $distance)
    {
        if (Auth::user()->can('delete car')) {
            if ($distance->car->created_by == \Auth::user()->creatorId()) {
                $distance->delete();
                return redirect()->route("{$this->route}index")->with('success', __('Employee successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


}
