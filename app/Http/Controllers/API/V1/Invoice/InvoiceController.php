<?php

namespace App\Http\Controllers\API\V1\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\v1\ChangePasswordRequest;
use App\Http\Requests\API\V1\Invoice\InvoiceSubmitRequest;
use App\Http\Requests\API\v1\OtpRequest;
use App\Http\Requests\API\v1\OtpVerfiyRequest;
use App\Http\Requests\API\v1\RegisterRequest;
use App\Http\Resources\API\V1\InvoiceResource;
use App\Models\Inbox;
use App\Models\User;
use App\Models\Utility;
use App\Services\UltraMsgService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Str;

class InvoiceController extends Controller
{

    /**
     * Submit Invoice "File Submission"
     * And Save It To the Inbox
     */
    public function submitInvoice(InvoiceSubmitRequest $request)
    {
        try {
            $user = $request->user();
            $path = 'uploads/inbox/' . $user->id . '/';
            $saved_inbox_path = saveImage($path, $request->file('invoice'));
            Inbox::create([
                'user_id' => $user->id,
                'path' => $saved_inbox_path
            ]);
            $code = 201;
            $status = true;
            $message = __("Invoice successfully created.");
            $data = [];
        } catch (Throwable $e) {
            info('Error In:' . get_class($this));
            info($e);
            $code = 500;
            $status = false;
            $message = __("Something is wrong.");
            $data = $e;
        }
        return generateApiResoponse($status, $code, $data ?? [], $message ?? '');
    }

    /**
     * Fetch User Invoices
     */
    public function fetchInvoices(Request $request)
    {
        $inboxes = null;
        try {
            $user = $request->user();
            $inboxes = Inbox::query()->select(['id', 'path', 'created_at'])->whereBelongsTo($user)->latest()->paginate(15);
            $data = InvoiceResource::collection($inboxes);
            $code = 201;
            $status = true;
        } catch (Throwable $e) {
            info('Error In:' . get_class($this));
            info($e);
            $code = 500;
            $status = false;
            $message = __("Something is wrong.");
        }
        return generateApiResoponse($status, $code, $data ?? [], $message ?? '' , paginator:$inboxes);
    }

}
