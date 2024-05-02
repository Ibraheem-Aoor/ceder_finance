<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\Plan;
use App\Models\Utility;
use File;
use Illuminate\Http\Request;
use Throwable;

class InboxController extends Controller
{
    public function index()
    {
        $data['inboxes'] = Inbox::whereBelongsTo(getAuthUser('web'))->latest()->get();
        return view('inbox.index', $data);
    }

    public function destroy(Inbox $inbox)
    {
        try {
            $inbox->delete();
            return redirect()->route('inbox.index')->with('success', __('Invoice successfully deleted.'));
        } catch (Throwable $e) {
            info('ERROR IN ' . get_class($this) . ' --  ' . $e->getMessage());
            return redirect()->route('inbox.index')->with('success', __('Some error occur, sorry for inconvenient. Please try again.'));
        }
    }
}
