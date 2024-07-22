<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        // $data['notifications'] = Notifications::all()->orderBy('status', 'DESC');
        $data['notifications'] = Notifications::orderBy('status')->orderBy('created_at', 'DESC')->get();
        $sender_ids = $data['notifications']->pluck('sender_id')->unique()->toArray();


        $users = User::whereIn('id', $sender_ids)->get()->keyBy('id');

        foreach ($data['notifications'] as $notification) {
            $notification->emp_data = $users[$notification->sender_id] ?? null;

        }
        return view('notification.index', $data);
    }
}
