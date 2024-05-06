<?php

namespace App\Http\Controllers;

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
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->view = $this->route = 'hr.employee';

    }


    public function index(Request $request)
    {
        // \Auth::user()->can('manage employees')
        if (true) {
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

        #\Auth::user()->can('create emplyoee')
        if (true) {
            $data = [];
            return view("{$this->view}.create", $data);

        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        #\Auth::user()->can('create emplyoee')

        if (true) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'mobile' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route($this->route . '.index')->with('error', $messages->first());
            }
            Employee::create([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'created_by' => getAuthUser('web')?->creatorId(),
            ]);
            return redirect()->route($this->route . '.index')->with('success', __('Employee Created Successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }





    public function edit(Employee $employee)
    {
        #\Auth::user()->can('create emplyoee')

        if (true) {
            $data['employee'] = $employee;
            return view('hr.employee.edit', $data);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, Employee $employee)
    {
        #\Auth::user()->can('create emplyoee')

        if (true) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'mobile' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route($this->route . '.index')->with('error', $messages->first());
            }
            $employee->update([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'created_by' => getAuthUser('web')?->creatorId(),
            ]);
            return redirect()->route($this->route . '.index')->with('success', __('Employee Updated Successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Employee $employee)
    {
        #\Auth::user()->can('delete emplyoee')

        if (true) {
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
