<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\NotificationDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $supervisorDetails = NotificationDetails::join('notifications', 'notifications.id', '=', 'notification_details.notif_id')
    ->where('notification_details.supervisor_id', Auth::user()->id)
    ->orderBy('notification_details.created_at', 'desc')
    ->get();

$managerDetails = NotificationDetails::join('notifications', 'notifications.id', '=', 'notification_details.notif_id')
    ->where('notification_details.manager_id', Auth::user()->id)
    ->orderBy('notification_details.created_at', 'desc')
    ->get();

$data = [];

// Check if supervisor notifications exist and assign to $data if supervisor_id matches
if ($supervisorDetails->isNotEmpty()) {
    foreach ($supervisorDetails as $detail) {
        if ($detail->supervisor_id == Auth::user()->id) {
            $data['supervisorDetails'][] = $detail;
        }
    }
}

// Check if manager notifications exist and assign to $data if manager_id matches
if ($managerDetails->isNotEmpty()) {
    foreach ($managerDetails as $detail) {
        if ($detail->manager_id == Auth::user()->id) {
            $data['managerDetails'][] = $detail;
        }
    }
}

// Now $data will contain 'supervisorDetails' and/or 'managerDetails' arrays with respective notifications


        return view('notification.overtime_notification.index', $data);
    }
}
