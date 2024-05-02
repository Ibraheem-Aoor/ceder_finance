<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\Plan;
use App\Models\Utility;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class FileController extends Controller
{
    public function download(Request $request)
    {
        try {
            return downloadFile(path: $request->query('file_path'), name: $request->query('name', null));
        } catch (Throwable $e) {
            Log::error('Erro While Download File For User_id:' . getAuthUser('web')?->id . ' || File Path: ' . $request->query('file_path'));
            return back();
        }
    }
}
