<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notifications;
use App\Models\NotificationDetails;

// *********** COSTUME METHOD ***********************************
function getNameFromNumber($num)
{
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2) . $letter;
    } else {
        return $letter;
    }
}
function genderValue($gender)
{
    if ($gender == 'Female' || $gender == 'F' || $gender == 'FEMALE') {
        return 2;
    } elseif ($gender == 'Male' || $gender == 'M' || $gender == 'MALE') {
        return 1;
    } else {
        return 0;
    }
}
function genderStringValue($gender)
{
    switch ($gender) {
        case '1':
            return "MALE";
        case 1:
            return "MALE";
        case '2':
            return "FEMALE";
        case 2:
            return "FEMALE";
        default:
            return "";
    }
}
function joinGrammar($prod_date)
{
    $prod_date_timestamp = strtotime($prod_date);
    $current_timestamp = time();

    if($prod_date_timestamp > $current_timestamp) {
        return "Will join";
    }
    return "Joined";
}
function monthDay($prod_date)
{
    if (isset($prod_date)) {
        $dt = Carbon::parse($prod_date);
        return $dt->format('M d');
    } else {
        return "";
    }
}
function slashedDate($prod_date)
{
    if (isset($prod_date)) {
        $dt = Carbon::parse($prod_date);
        return $dt->format('m/d/Y');
    } else {
        return "";
    }
}

function prettyDate($prod_date)
{
    if (isset($prod_date)) {
        $dt = Carbon::parse($prod_date);
        return $dt->format('l, M d, Y');
    } else {
        return "";
    }
}

function timeDate($date)
{
    if (isset($date)) {
        $dt = Carbon::parse($date);
        return $dt->format('m/d/Y h:i A');
    } else {
        return "";
    }
}

function truncate($string, $length, $html = true)
{
    if (strlen($string) > $length) {
        if ($html) {
            // Grabs the original and escapes any quotes
            $original = str_replace('"', '\"', $string);
        }

        // Truncates the string
        $string = substr($string, 0, $length);

        // Appends ellipses and optionally wraps in a hoverable span
        if ($html) {
            $string = '<span title="' . $original . '">' . $string . '&hellip;</span>';
        } else {
            $string .= '...';
        }
    }

    return $string;
}
function curl_get_contents($url)
{
    $ch = curl_init();
    $timeout = 5;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

    $data = curl_exec($ch);

    curl_close($ch);

    return $data;
}

function leaveCredits($leave_credit)
{
    if($leave_credit == 0) {
        $leave_credit = "0 day";
    } elseif($leave_credit == 0.5) {
        $leave_credit = "1/2 day";
    } elseif ($leave_credit == 1) {
        $leave_credit = "1 day";
    } elseif ($leave_credit > 1) {
        $leave_credit = "$leave_credit day";
    }

    return "You have $leave_credit leave credits.";
}

function breadCrumbs()
{
    $path = request()->path();

    return ucwords(join(' / ', explode('/', $path)));
}

function stringLimit($text = null, $max = 50)
{
    if(empty($text)) {
        return '---';
    }

    return (strlen(htmlentities($text)) > $max) ? substr(htmlentities($text), 0, $max)." ..." : htmlentities($text);
}

function timekeepingStatus($item = null)
{
    if(empty($item)) {
        return '---';
    }

    $status = $item->status;
    if($item->status == 'APPROVED' && !empty($item->approved_reason)) {
        $status = 'REVERTED';
    }
    // if($item->status == 'PENDING') {
    //     if(empty($item->recommend_date)) {
    //         $status .= ' <br><small>(Recommendation / Approval)</small>';
    //     } else {
    //         $status .= ' <br><small>(Approval)</small>';
    //     }
    // }
    $lowerStatus = mb_strtolower($status, 'UTF-8');
    $status = ucwords($lowerStatus);
    return $status;
}

function leaveStatus($status = null)
{
    $txt = "Pending <br> <small>(Recommendation / Approval)</small>";
    if(empty($status)) {
        return $txt;
    }

    switch($status) {
        case 1:
            $txt = 'Approved';
            break;
        case 2:
            $txt = 'Not Approved';
            break;
        case 3:
            $txt = "Pending <br> <small>(Approval)</small>";
            break;
    }

    return $txt;
}

function timekeepingApprovedStatus($item = null)
{
    $txt = '<span class="fa fa-refresh"></span>&nbsp; Waiting for response';

    if(empty($item)) {
        return $txt;
    }

    switch($item->status) {
        case 'APPROVED':
            $txt = '<span class="fa fa-clock-o text-success"></span> Timekeeping';
            if(!empty($item->approved_reason)) {
                $txt = '<span class="fa fa-undo text-declined"></span> Reverted <br>Reason for incompletion <br>'.htmlentities($item->approved_reason);
            }
            if(!empty($item->date)) {
                $txt = '<span class="fa fa-check text-success"></span> Approved';
            }
            break;
        case 'DECLINED':
            $txt = '<span class="fa fa-thumbs-down text-declined"></span> Declined <br>Reason for disapproval <br>'.htmlentities($item->declined_reason);
            break;
        case 'VERIFYING':
            $txt = '<span class="fa fa-spinner text-verify"></span> Verifying';
            break;
        case 'VERIFIED':
            $txt = '<span class="fa fa-check-circle-o text-verified"></span> Verified';
            break;
        case 'COMPLETED':
            $txt = '<span class="fa fa-check text-success"></span> Completed';
    }

    return nl2br($txt);
}

function numberOfHours($time_in = null, $time_out = null, $undertime = false, $minutes = false)
{
    $no_of_hours = '';
    if(!empty($time_in) && !empty($time_out)) {
        $start = new DateTime($time_in);
        $end = $start->diff(new DateTime($time_out));
        $end->d = $end->d * 24;
        if($undertime) {
            if($end->h > 4) {
                $end->h = ($end->h - 1) + $end->d;
            } else {
                $end->h += $end->d;
            }
        } else {
            $end->h = $end->h + $end->d;
        }

        if($minutes) {
            $no_of_hours = "{$end->h} hrs";
            if($end->i > 0) {
                $no_of_hours .= " {$end->i} mins";
            }
        } else {
            $no_of_hours = number_format($end->h, 2);
        }
    }

    return $no_of_hours;
}

function generateRandomString($length = 12)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdef', ceil($length / strlen($x)))), 1, $length);
}

if (!function_exists('customDate')) {
    function customDate($date = null, $string = 'Y-m-d')
    {
        $date = $date ?: today();

        return date($string, strtotime($date));
    }
}

if (!function_exists('widgetPercentage')) {
    function widgetPercentage($new, $old)
    {
        // $percentage = ($new == 0) ? 100 : ($new / $old) * 100;
        // $percentage = ($old > $new) ? $percentage * -1 : $percentage;
        // $icon = ($old > $new) ? 'down' : 'up';
        // $text = ($old > $new) ? 'Lower' : 'higher';

        // return '<i class="fa fa-level-'.$icon.' m-r-5"></i><small>'.number_format($percentage).'% '.$text.'</small>';
    }
}

if (!function_exists('formatName')) {
    function formatName($name)
    {
        return mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    }
}

if (!function_exists('getEmail')) {
    function getEmail($email)
    {
        $icon = 'envelope-open';
        $title = 'Outlook';
        if (strpos($email, 'gmail.com') !== false) {
            $icon = 'google';
            $title = 'GMail';
        } elseif (strpos($email, 'yahoo.com') !== false) {
            $icon = 'yahoo';
            $title = 'Yahoo';
        }

        return array('icon' => $icon, 'title' => $title);
    }
}

function getNotifications($receiver_id)
{
    $notifications = [];
    $Id = [];
    $url = [];
    $createdAt = [];
    if($receiver_id) {
        // Retrieve details for supervisor notifications
        $supervisorDetails = NotificationDetails::join('notifications', 'notifications.id', '=', 'notification_details.notif_id')
        ->where('notification_details.supervisor_id', $receiver_id) // Adjusted to reference the 'notifications' table
        ->where('notification_details.supervisor_status', 0)
        ->orderBy('notification_details.created_at', 'desc')
        ->take(4)
        ->get();

        // Retrieve details for manager notifications
        $managerDetails = NotificationDetails::join('notifications', 'notifications.id', '=', 'notification_details.notif_id')
        ->where('notification_details.manager_id', $receiver_id)
        ->where('notification_details.manager_status', 0)
        ->orderBy('notification_details.created_at', 'desc')
        ->take(4)
        ->get();

        // Check if there are any supervisor details and perform actions
        if ($supervisorDetails->isNotEmpty()) {
            foreach ($supervisorDetails as $detail) {
                if ($detail->supervisor_id == $receiver_id) {
                    $sender = User::find($detail->sender_id);
                    $lowername = mb_strtolower($sender->fullname2(), 'UTF-8');
                    $notifications[] = $detail->message . ' : ' . ucwords($lowername);
                    $Id[] = $detail->id;
                    $url[] = $detail->url;
                    $createdAt[] = date('Y-m-d\TH:i:s\Z', strtotime($detail->created_at));
                }
            }
        }

        // Check if there are any manager details and perform actions
        if ($managerDetails->isNotEmpty()) {
            foreach ($managerDetails as $detail) {
                if ($detail->manager_id == $receiver_id) {
                    $sender = User::find($detail->sender_id);
                    $lowername = mb_strtolower($sender->fullname2(), 'UTF-8');
                    $notifications[] = $detail->message . ' : ' . ucwords($lowername);
                    $Id[] = $detail->id;
                    $url[] = $detail->url;
                    $createdAt[] = date('Y-m-d\TH:i:s\Z', strtotime($detail->created_at));
                }
            }
        }

    } else {
        $notifications[] = "Error: Receiver ID not provided";
        $createdAt[] = "Error: Receiver ID not provided";
    }

    return [
        'notifications' => $notifications,
        'createdAt' => $createdAt,
                'Id' => $Id,
                'url' => $url
    ];
}

function hasUnread($receiver_id)
{
    $supervisor_unread = NotificationDetails::where('supervisor_id', $receiver_id)->where('supervisor_status', 0)->first();
    $manager_unread = NotificationDetails::where('manager_id', $receiver_id)->where('manager_status', 0)->first();

    if ($supervisor_unread) {
        return $supervisor_unread;
    }
    if ($manager_unread) {
        return $manager_unread;
    }

}

function notificationCount($receiver_id)
{
    // $notifCount = Notifications::where('receiver_id', $receiver_id)->where('status', 0)->count();

    // return $notifCount;
}

// function getNotification($receiver_id)
// {
//     $users = '';
//     if($receiver_id){
//         $userInfos = Notifications::where('receiver_id', $receiver_id)->get();
//         if($userInfos->isEmpty()) {
//             $users = "No notifications";
//         } else {
//             // Concatenate first names of users with notifications
//             $userNames = $userInfos->pluck('message')->implode(', ');
//             $users = "$userNames";
//         }
//     } else {
//         $users = "Error: Receiver ID not provided";
//     }

//     return $users;
// }
