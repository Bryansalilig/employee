<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\NotificationDetails;
use App\Models\OvertimeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $supervisorDetails = NotificationDetails::join('notifications', 'notifications.id', '=', 'notification_details.notif_id')
            ->leftJoin('overtime_request', 'overtime_request.slug', '=', 'notification_details.ot_slug')
            ->where('overtime_request.status', "=", "PENDING")
            ->where('notification_details.supervisor_id', Auth::user()->id)
            ->orderBy('notification_details.created_at', 'desc')
            ->get();

        $managerDetails = NotificationDetails::join('notifications', 'notifications.id', '=', 'notification_details.notif_id')
            ->leftJoin('overtime_request', 'overtime_request.slug', '=', 'notification_details.ot_slug')
            ->where('overtime_request.status', "=", "PENDING")
            ->where('notification_details.manager_id', Auth::user()->id)
            ->orderBy('notification_details.created_at', 'desc')
            ->get();

        $senderDetails = NotificationDetails::join('notifications', 'notifications.id', '=', 'notification_details.notif_id')
            ->leftJoin('overtime_request', 'overtime_request.slug', '=', 'notification_details.ot_slug')
            ->where('overtime_request.status', "=", "APPROVED")
            ->where('notifications.sender_id', Auth::user()->id)
            // ->where('notification_details.sender_status', 0)
            ->get();

        // echo "<pre>";
        // print_r($managerDetails);
        // return;

        $data = [];
        $data['notifications'] = [];

        // Check if supervisor notifications exist and assign to $data if supervisor_id matches
        if (!empty($supervisorDetails)) {
            foreach ($supervisorDetails as $detail) {
                if ($detail->supervisor_id == Auth::user()->id) {
                    $sender = User::find($detail->sender_id);
                    $overtime_data = OvertimeRequest::getNotificationData($detail->ot_slug);
                    $detail->recommend_date = $overtime_data->recommend_date;
                    $detail->sender = $sender->fullname();
                    $data['notifications'][] = $detail;
                }
            }
        }
        // Check if manager notifications exist and assign to $data if manager_id matches
        if (!empty($managerDetails)) {
            foreach ($managerDetails as $detail) {
                if ($detail->manager_id == Auth::user()->id) {
                    $sender = User::find($detail->sender_id);
                    $overtime_data = OvertimeRequest::getNotificationData($detail->ot_slug);
                    $detail->recommend_date = $overtime_data->recommend_date;
                    $detail->sender = $sender->fullname();
                    $data['notifications'][] = $detail;
                }
            }
        }
        // Check if sender notifications exist and assign to $data if sender matches
        if (!empty($senderDetails)) {
            foreach ($senderDetails as $detail) {
                if ($detail->sender_id == Auth::user()->id) {
                    $sender = User::find($detail->sender_id);
                    $overtime_data = OvertimeRequest::getNotificationData($detail->ot_slug);
                    $detail->reason = "Your Overtime has been Approved.";
                    $detail->sender = $sender->fullname();
                    $data['notifications'][] = $detail;
                }
            }
        }

        // echo "<pre>";
        // print_r($managerDetails);
        // return;

        // Now $data will contain 'supervisorDetails' and/or 'managerDetails' arrays with respective notifications

        return view('notification.overtime_notification.index', $data);
    }
}
