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
use App\Models\Employee;
use App\Models\EmployeeWorkHours;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Throwable;

class CarController extends Controller
{
    public function __construct()
    {
        $this->view = 'cars.';
        $this->route = 'cars.';
    }


    public function index(Request $request)
    {
        if (Auth::user()->can('view car')) {
            $data['cars'] = Car::query()
                ->with(['brand:id,name', 'fuel:id,name' ,'walks:id,walked_distance'])
                ->latest()
                ->createdBy(getAuthUser('web')->creatorId())
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
            return view("{$this->view}.create");
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
                        'license_plate' => 'required|string|unique:cars',
                        'walked_distance' => 'required|numeric',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->route($this->route . 'index')->with('error', $messages->first());
                }
                $car_data = $this->getCarDataFromApi($request->input('license_plate'));
                if (empty($car_data)) {
                    throw new \Exception();
                }
                DB::beginTransaction();
                $brand = CarBrand::query()->updateOrCreate([
                    'name' => $car_data['vehicleData']['CarMake']['CurrentTextValue'],
                ], [
                    'name' => $car_data['vehicleData']['CarMake']['CurrentTextValue'],
                ]);
                $fuel = CarFuel::query()->updateOrCreate([
                    'name' => $car_data['vehicleData']['FuelType']['CurrentTextValue'],
                ], [
                    'name' => $car_data['vehicleData']['FuelType']['CurrentTextValue'],
                ]);
                Car::query()->create([
                    'trade_name' => $car_data['vehicleData']['Description'],
                    'color' => $car_data['vehicleJson']['Colour'],
                    'license_plate' => $car_data['vehicleJson']['Extended']['kenteken'],
                    'walked_distance' => $request->input('walked_distance'),
                    'extra_data' => $car_data['vehicleJson'],
                    'brand_id' => $brand->id,
                    'fuel_id' => $fuel->id,
                    'created_by' => getAuthUser('web')->creatorId(),
                ]);
                DB::commit();
                return redirect()->route($this->route . 'index')->with('success', __('Employee Created Successfully'));
            } catch (Throwable $e) {
                // dd($e);
                DB::rollBack();
                info('ERROR IN ' . __METHOD__ . ' || MESSSAGE:' . $e->getMessage());
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    /**
     * Make API CALL To Get The Car Data With the given License Plate
     */
    protected function getCarDataFromApi($license_plate): array
    {
        $regcheck = config('services.regcheck');
        $query_params['RegistrationNumber'] = $license_plate;
        $query_params['username'] = $regcheck['username'];
        $response = Http::withoutVerifying()->get($regcheck['base_url'] . '/CheckNetherlands', $query_params);
        if ($response->successful()) {
            $xml = simplexml_load_string($response->body());
            $response_in_array = json_decode(json_encode($xml), true);
            $response_in_array['vehicleJson'] = json_decode($response_in_array['vehicleJson'], true);
            return $response_in_array;
        }
        info('ERROR IN ' . __METHOD__ . ' || API RESPONSE:' . $response->body());
        return [];
    }

    public function destroy(Car $car)
    {
        if (Auth::user()->can('delete employees')) {
            if ($car->created_by == \Auth::user()->creatorId()) {
                $car->delete();
                return redirect()->route("{$this->route}index")->with('success', __('Employee successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }




}
