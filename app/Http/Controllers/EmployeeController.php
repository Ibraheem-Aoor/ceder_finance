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
use App\Models\Employee;
use App\Models\EmployeeWorkHours;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Throwable;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->view = $this->route = 'hr.employee';

    }


    public function index(Request $request)
    {
        if (Auth::user()->can('view employees')) {
            $data['employees'] = Employee::query()
                ->whereBelongsTo(getAuthUser('web'), 'company')
                ->latest()
                ->get();
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
            // dd($data);
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
                    'legitimation_type' => 'required|'.Rule::in(EmployeeLegtemationTypeEnum::getValues()),
                    'legitimation_number' => 'required|',
                    'bsn' => 'required',
                    'valid_until' => 'required|date',
                    'contract_date' => 'required|date',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date',
                    'salary' => 'required',
                    'salary_payment' => 'required',
                    'id_file' =>'required|file|mimes:jpg,png,jpeg,webp,pdf|max:2048',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route($this->route . '.index')->with('error', $messages->first());
            }
            $employee = $request->except('_token');
            $employee['created_by'] = getAuthUser()->id;
            $employee['id_file'] = saveImage('emplpoyees/'.getAuthUser()->id.'/', $request->file('id_file'));
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
                    'legitimation_type' => 'required|'.Rule::in(EmployeeLegtemationTypeEnum::getValues()),
                    'legitimation_number' => 'required|',
                    'bsn' => 'required',
                    'valid_until' => 'required|date',
                    'contract_date' => 'required|date',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date',
                    'salary' => 'required',
                    'salary_payment' => 'required',
                    'id_file' =>'nullable|file|mimes:jpg,png,jpeg,webp,pdf|max:2048',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route($this->route . '.index')->with('error', $messages->first());
            }
            $employee_to_update = $request->except('_token');
            $employee_to_update['id_file'] = $request->hasFile('id_file') ?  saveImage('emplpoyees/'.getAuthUser()->id.'/', $request->file('id_file')) : $employee->id_file;
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
        if (Auth::user()->can('edit employees')) {
            try {
                $data['employee'] = $employee;
                $data['today_name'] = Carbon::today()->format('l');
                $data['today_date'] = Carbon::today()->format('Y-m-d');
                $data['today_work_hours'] = EmployeeWorkHours::query()->where('employee_id', $employee->id)->where('date', $data['today_date'])->first()?->hours;
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
    public function updateSchedule(Request $request, Employee $employee)
    {
        if (Auth::user()->can('edit employees')) {

            try {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'hours' => 'required|numeric',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->route($this->route . '.index')->with('error', $messages->first());
                }
                EmployeeWorkHours::updateOrCreate([
                    'employee_id' => $employee->id,
                    'day' => Carbon::today()->format('l'),
                ], [
                    'employee_id' => $employee->id,
                    'day' => Carbon::today()->format('l'),
                    'date' => Carbon::today()->format('Y-m-d'),
                    'hours' => $request->hours,
                ]);
                return redirect()->route($this->route . '.index')->with('success', __('Employee Updated Successfully'));
            } catch (Throwable $e) {
                dd($e);
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }



    public function downloadSchedule(Request $request, Employee $employee)
    {
        if (Auth::user()->can('manage employees')) {

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
                    'employee_name' => $data->employee->name, // Assuming you have an 'employees' table and a relationship set up
                ];
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
        return Excel::download(new WeeklyReportsExport($reportData, $employee->name), $employee->name . '.xlsx');
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
