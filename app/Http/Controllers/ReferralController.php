<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReferralSubmitted;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ReferralController extends Controller
{
    public function index()
    {
        $data['referrals'] = Referral::orderByDesc('created_at')->get();

        return view('referral.referral', $data);
    }

    public function create() {
        return view('referral.create');
    }

    public function show($slug) {
        $referral = Referral::where('slug', $slug)->first();
        if(empty($referral)){
            return redirect(url('404'));
        }

        $referral->acknowledged = 1;
        $referral->save();

        $data['referral'] = $referral;

        return view('referral.show', $data);
    }

    public function store(Request $request)
    {
        if ($request->hasFile("file")) {
            $file = $request->file('file');
            
            // Generate a unique filename using the original name
            $filename = $file->getClientOriginalName();
            
            // Store the file with the generated filename in the 'images/referral-attachment' directory
            $path = $file->storeAs('images/referral-attachment', $filename);
        
            // Get the asset URL for the stored file
            $fileUrl = asset('storage/' . $path);
        }

        $referral = new Referral();
        $referral->referrer_first_name = $request->first_name;
        $referral->referrer_middle_name = $request->middle_name;
        $referral->referrer_last_name = $request->last_name;
        $referral->referrer_department = $request->department_name;
        $referral->referral_first_name = $request->referral_first_name;
        $referral->referral_middle_name = $request->referral_middle_name;
        $referral->referral_last_name = $request->referral_last_name;
        $referral->referral_contact_number = $request->referral_contact_number;
        $referral->referral_email = $request->referral_email;
        $referral->position_applied = $request->position_applied;
        $referral->reference_link = $request->ref_link;
        $referral->attachment = (!empty($fileUrl)) ? $fileUrl : '';

        $users = User::ActiveEmployees()->where('dept_code', 'TLA01')->select('email')->get();
      
        $emails = [];
        foreach($users as $user) { array_push($emails, $user->email); }

        if ($referral->save()) {
            // Successfully created
            $first = substr(time(), 2);
            $second = substr(md5($referral->id), -4);
            $third = substr(uniqid(), -4);
            $fourth = substr(rand(), -4);
            $fifth = generateRandomString();
    
            $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;
            
            $referral->slug = $slug;
            $referral->save();

            // Mail::to('hrd@elink.com.ph')->cc($emails)->send(new ReferralSubmitted($referral));

            return redirect(url('referral/'.$slug))->with('success', 'Referral created successfully.');
        } else {
            // Failed to create
            return back()->with('error', 'Failed to create referral.');
        }
    }

    public function download($filename)
    {
        $path = 'images/referral-attachment/' . $filename; // Adjust the path as needed

        if (Storage::exists($path)) {
            $file = Storage::get($path);
            $headers = [
                'Content-Type' => 'application/pdf', // For PDF
                'Content-Type' => 'application/pdf',  // For Microsoft Word DOCX
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Type' => 'application/msword', // For Excel XLSX
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Type' => 'application/vnd.ms-excel', // For Excel XLS
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ];

            return Response::make($file, 200, $headers);
        } else {
            abort(404, 'File not found');
        }
    }
}
