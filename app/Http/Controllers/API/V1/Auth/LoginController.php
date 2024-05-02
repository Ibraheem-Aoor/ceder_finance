<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\v1\ChangePasswordRequest;
use App\Http\Requests\API\v1\OtpRequest;
use App\Http\Requests\API\v1\OtpVerfiyRequest;
use App\Http\Requests\API\v1\RegisterRequest;
use App\Models\User;
use App\Models\Utility;
use App\Services\UltraMsgService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Str;

class LoginController extends Controller
{


    public function login(LoginRequest $request)
    {

        try {
            $user  = User::query()->where('email', $request->email)->first();
            $data['user'] = [
                'name' => $user->name,
                'email' => $user->email,
            ];
            if (isset($data['user']) && Hash::check($request->password, $user->password) && $user->is_accepted) {
                $data['token'] = $user->createToken($request->userAgent())?->plainTextToken;
                $logo_path = DB::table('settings')->where('created_by' , $user->creatorId())->whereName('company_logo')->first()?->value;
                $data['user']['logo'] = url(getImageUrl($logo_path));
                $code = 201;
                $status = true;
                $message = "Success";
            } else {
                unset($data['user']);
                $code = 401;
                $status = false;
                $message = __('auth.failed');
            }
        } catch (Throwable $e) {
            dd($e);
            $code = 500;
            $status = false;
            $message = __('general.response_messages.error');
            $data= [];
        }
        return generateApiResoponse($status, $code, $data ?? [], $message ?? '');
    }



    public function logout(Request $request)
    {
        try {
            if ($request->user()->currentAccessToken()?->delete()) {
                $code = 201;
                $status = true;
                $message = __('auth.logout_success');
            } else {
                $code = 404;
                $status = false;
            }
        } catch (Throwable $e) {
            $code = 500;
            $status = false;
            $message = __('general.response_messages.error');
        }
        return generateApiResoponse($status, $code, [], $message);
    }



}
