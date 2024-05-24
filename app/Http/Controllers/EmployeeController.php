<?php

namespace App\Http\Controllers;

use App\Enums\EmployeeLegtemationType;
use App\Enums\EmployeeLegtemationTypeEnum;
use App\Enums\EmployeeSalaryPaymentPhaseEnum;
use App\Enums\EmployeSalarayPaymentPhaseEnum;
use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillProduct;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Mail\BillPaymentCreate;
use App\Models\Mail\BillSend;
use App\Models\Mail\VenderBillSend;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Utility;
use App\Models\Vender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BillExport;
use App\Exports\WeeklyReportsExport;
use App\Http\Requests\Company\EmployeeWorkHoursRequest;
use App\Models\Employee;
use App\Models\EmployeeWorkHours;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Throwable;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->view = 'HR.employee';
        $this->route = 'hr.employee';

    }


    public function index(Request $request)
    {
        if (Auth::user()->can('view employees')) {
            $data['employees'] = Employee::query()
                ->whereBelongsTo(getAuthUser('web'), 'company')
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

        if (Auth::user()->can('create employees')) {
            $data = [
                'legtemate_types' => EmployeeLegtemationTypeEnum::cases(),
                'salary_payment_phases' => EmployeSalarayPaymentPhaseEnum::cases(),
            ];
            return view("{$this->view}.create", $data);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('create employees')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'dob' => 'required|date',
                    'phone' => 'required|numeric',
                    'email' => 'required|email',
                    'role' => 'required',
                    'account_number' => 'required',
                    'alias' => 'required',
                    'legitimation_type' => 'required|' . Rule::in(EmployeeLegtemationTypeEnum::getValues()),
                    'legitimation_number' => 'required|',
                    'bsn' => 'required',
                    'valid_until' => 'required|date',
                    'contract_date' => 'required|date',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date',
                    'salary' => 'required',
                    'salary_payment' => 'required',
                    'id_file' => 'required|file|mimes:jpg,png,jpeg,webp,pdf|max:2048',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route($this->route . '.index')->with('error', $messages->first());
            }
            $employee = $request->except('_token');
            $employee['created_by'] = getAuthUser()->id;
            $employee['id_file'] = saveImage('emplpoyees/' . getAuthUser()->id . '/', $request->file('id_file'));
            Employee::create($employee);
            return redirect()->route($this->route . '.index')->with('success', __('Employee Created Successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }





    public function edit(Employee $employee)
    {
        #\Auth::user()->can('create emplyoee')

        if (Auth::user()->can('edit employees')) {
            $data = [
                'employee' => $employee,
                'legtemate_types' => EmployeeLegtemationTypeEnum::cases(),
                'salary_payment_phases' => EmployeSalarayPaymentPhaseEnum::cases(),
            ];
            return view('hr.employee.edit', $data);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, Employee $employee)
    {
        if (Auth::user()->can('edit employees')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'dob' => 'required|date',
                    'phone' => 'required|numeric',
                    'email' => 'required|email',
                    'role' => 'required',
                    'account_number' => 'required',
                    'alias' => 'required',
                    'legitimation_type' => 'required|' . Rule::in(EmployeeLegtemationTypeEnum::getValues()),
                    'legitimation_number' => 'required|',
                    'bsn' => 'required',
                    'valid_until' => 'required|date',
                    'contract_date' => 'required|date',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date',
                    'salary' => 'required',
                    'salary_payment' => 'required',
                    'id_file' => 'nullable|file|mimes:jpg,png,jpeg,webp,pdf|max:2048',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route($this->route . '.index')->with('error', $messages->first());
            }
            $employee_to_update = $request->except('_token');
            $employee_to_update['id_file'] = $request->hasFile('id_file') ? saveImage('emplpoyees/' . getAuthUser()->id . '/', $request->file('id_file')) : $employee->id_file;
            $employee->update($employee_to_update);
            return redirect()->route($this->route . '.index')->with('success', __('Employee Updated Successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }



    /**
     * Edit Employee Work Hours Schedule.
     */
    public function editSchedule(Request $request, Employee $employee)
    {
        $auth_user = getAuthUser();
        if ($auth_user->can('edit employees')) {
            try {
                $data['employee'] = $employee;
                $data['customers'] = Customer::query()->createdBy($auth_user->creatorId())->get(['id', 'name']);
                $data['work_locations'] = $this->getWorkLocations($request->week_start, $employee);
                $data['customer_id'] = @$data['work_locations']?->first()?->first()?->customer_id;
                return view('HR.employee.edit_schedule', $data);
            } catch (Throwable $e) {
                dd($e);
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    /**
     * Edit Employee Work Hours Schedule.
     */
    public function updateSchedule(EmployeeWorkHoursRequest $request, Employee $employee)
    {
        if (Auth::user()->can('edit employees')) {
            try {

                $locations = $request->input('locations');
                // Get The Start Of The Week According To The Filled Dates
                $dates = $locations[array_key_first($locations)]['dates'];
                $start_of_the_filled_week = Carbon::parse($dates[array_key_last($dates)])->startOfWeek()->toDateString();
                $days_in_dates = $this->getDaysInDates($start_of_the_filled_week);
                // Delete The Requested Week for "Syncing"
                $employee->workHours()->whereIn('date', array_values($days_in_dates))->delete();
                foreach ($locations as $location) {
                    $location_name = $location['name'];
                    $dates = $location['dates'];
                    $hours = $location['hours'];

                    // insert data
                    foreach ($dates as $day => $date) {
                        EmployeeWorkHours::create([
                            'employee_id' => $employee->id,
                            'day' => $day,
                            'date' => $date,
                            'hours' => @$hours[$day] ?? 0,
                            'location' => $location_name,
                            'customer_id' => $request->input('customer'),
                        ]);
                    }
                }

                $work_locations = $this->getWorkLocations($request->week_start, $employee);
                $view_data['employee'] = $employee;
                $view_data['week_start'] = $request->week_start;
                $view_data['work_locations'] = $work_locations;
                return response()->json([
                    'status' => true,
                    'message' => __('Success'),
                    'work_locations' => $work_locations,
                    'customer_id' => @$work_locations?->first()?->first()->customer_id,
                    'html' => view('HR.employee.weeks_table', $view_data)->render(),
                ]);
            } catch (Throwable $e) {
                dd($e);
                return response()->json([
                    'status' => false,
                    'message' => __('Failed'),
                ]);
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Get The Work Hours Of The Given Employee In The Given Week.
     * Each Week 'days' Related To Same Customer And Location
     */
    protected function getWorkLocations($week_start = null, Employee $employee): Collection
    {
        $days_in_dates = $this->getDaysInDates($week_start);
        // Get The Work Hours For The Given Week Only.
        return $employee->workHours()->whereIn('date', array_values($days_in_dates))->get()->groupBy('location');
    }

    protected function getPeriod($week_start = null)
    {
        if (isset($week_start)) {
            $week_start = Carbon::parse($week_start);
        } else {
            $week_start = Carbon::now()->startOfWeek();
        }
        $week_end = $week_start->copy()->endOfWeek();
        return CarbonPeriod::create($week_start, $week_end);
    }

    public function getDaysInDates($week_start = null)
    {
        $days = $this->getPeriod($week_start);
        foreach ($days as $day) {
            $days_in_dates[$day->format('l')] = $day->toDateString();
        }
        return $days_in_dates;
    }



    public function downloadSchedule(Request $request, Employee $employee)
    {
        $auth_user = getAuthUser('web');
        if ($auth_user->can('manage employees')) {

            // Get the start and end dates of the year
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();

            // Retrieve work hour data for the entire year
            $yearlyData = EmployeeWorkHours::query()
                ->whereBelongsTo($employee)
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date')
                ->get();

            // Organize the data by week
            $reportData = [];
            foreach ($yearlyData as $data) {
                $weekNumber = Carbon::parse($data->date)->weekOfYear; // Get the week number
                $reportData[$weekNumber][] = [
                    'day' => $data->day, // Get the day name
                    'date' => $data->date,
                    'hours' => $data->hours,
                    'employee_name' => $data->employee->first_name . ' ' . $data->employee->last_name, // Assuming you have an 'employees' table and a relationship set up
                    'customer' => $data->customer->name,
                    'location' => $data->location,
                ];
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $file_name = $auth_user->employeeNumberFormat($employee->id) . '_' . date('Y') . '_' . date('m') . '_' . date('d') . '.xlsx';
        return Excel::download(new WeeklyReportsExport($reportData, $employee->name), $file_name);
    }


    public function destroy(Employee $employee)
    {

        if (Auth::user()->can('delete employees')) {

            if ($employee->created_by == \Auth::user()->creatorId()) {
                $employee->delete();
                return redirect()->route("{$this->route}.index")->with('success', __('Employee successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }







    public function export()
    {
        $name = 'customer_' . date('Y-m-d i:h:s');
        $data = Excel::download(new BillExport(), $name . '.xlsx');

        return $data;
    }
}
