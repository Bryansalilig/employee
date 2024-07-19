<?php
/**
 * Controller for Company Policy Module
 *
 * This controller handles the view page of the Company Policy Module.
 *
 * @version 1.0
 * @since 2024-04-26
 *
 * Changes:
 * - 2024-04-26: File creation
 */

// Declare the namespace for the controller
namespace App\Http\Controllers;

use App\Models\CompanyPolicy;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
  /**
   * @var array
   */
  public static $data = [];

  /**
   * Constructor method to set up session data.
   *
   * This method initializes session variables for view and menu navigation
   * within the Board > Activity module.
   */
  public function __construct()
  {
    // Set variables for view and menu navigation
    self::$data['menu'] = 'company';
  }

  /**
   * Method to display all active company policies.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    self::$data['items'] = CompanyPolicy::where('status', 'ACTIVE')->orderBy('id')->get();

    return view('company.index', self::$data);
  }

  /**
   * Method to display all list of company policies.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function list()
  {
    self::$data['items'] = CompanyPolicy::all();

    return view('company.list', self::$data);
  }

  /**
   * Show the form for creating a new company policy.
   *
   * @return \Illuminate\Contracts\View\View The view displaying the company policy form.
   */
  public function create()
  {
    // Return the view for creating a new banner with data
    return view('company.create', self::$data);
  }

  /**
   * Store a newly created company policy.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Create a new instance of Company model
    $item = new CompanyPolicy();

    // Assign input values to the corresponding properties
    $item->title = $request->title;
    $item->subtitle = $request->subtitle;
    $item->status = $request->status;

    // Create a variable $url
    $url = '';

    // Check if image is uploaded
    if ($request->hasFile("file_url")) {
      // Generate a unique filename for the image
      $filename = time() . '_' . uniqid() . '.' . $request->file_url->getClientOriginalExtension();

      // Save the image to the storage disk
      $path = Storage::disk('files')->putFileAs("policy", $request->file_url, $filename);

      // Update the $url property with the asset path
      $url = asset('storage/app/files/' . $path);

      // Update the image URL with the $url
      $item->file_url =  $url;
    }

    // Attempt to save the banner record
    if ($item->save()) {
      // Save a log for the banner
      self::saveLog($item, $request, 'insert', $path, $url);

      // Generate a unique slug for the activity
      $first = substr(strtotime($item->created_at), 2);
      $second = substr(md5($item->id), -4);
      $third = substr(uniqid(), -4);
      $fourth = substr(rand(), -4);
      $fifth = generateRandomString();

      // Combine components to form the slug
      $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;

      // Update the slug property of the activity
      $item->slug = $slug;
      $item->save();

      // Redirect to the newly created banner
      return redirect(route('company.list'))->with('success', 'Successfully Added a Company Policy!');
    } else {
      // Redirect back with error message if saving fails
      return back()->with('error', 'Something went wrong.');
    }
  }

  /**
   * Display the form for editing the specified banner.
   *
   * @param  string $slug The slug of the banner to be edited
   * @return \Illuminate\Http\Response
   */
  public function edit($slug)
  {
    // Retrieve the banner record based on the provided slug
    $item = CompanyPolicy::where('slug', $slug)->first();

    // Check if the banner record exists
    if (empty($item)) {
      // If the banner record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Pass the banner data to the view
    self::$data['item'] = $item;

    // Retrieve logs related to the current banner
    self::$data['logs'] = Log::getLog('Company', $item->id);

    // Load the edit view with the banner data
    return view('company.edit', self::$data);
  }

  /**
   * Update the specified company policy in storage.
   *
   * @param  \Illuminate\Http\Request  $request The HTTP request object containing the updated company policy data
   * @param  int  $id The ID of the company policy to be updated
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // Find the company policy record by ID
    $item = CompanyPolicy::find($id);

    // Check if the company policy record exists
    if (empty($item)){
      // If the company policy record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Copy data from item to keep the original
    $old = CompanyPolicy::find($id);

    // Update activity data with the values from the request
    $item->title = $request->title;
    $item->subtitle = $request->subtitle;
    $item->status = $request->status;

    // Create a variable $url
    $url = $item->file_url;

    // Check if file is uploaded
    if ($request->hasFile("file_url")) {
      // Delete the previous file associated with the company policy
      self::deleteFile($item->file_url);

      // Generate a unique filename for the new file
      $filename = time() . '_' . uniqid() . '.' . $request->file_url->getClientOriginalExtension();

      // Store the new file in the designated directory
      $path = Storage::disk('files')->putFileAs("policy", $request->file_url, $filename);

      // Update the $url property with the asset path
      $url = asset('storage/app/files/' . $path);

      // Update the file URL with the $url
      $item->file_url =  $url;
    }

    // Save the updated file record
    if ($item->save()) {
      // Log the update action
      self::saveLog($old, $request, 'update', $url);

      // Redirect back with success message upon successful update
      return back()->with('success', 'Successfully Updated the Company Policy!');
    } else {
      // Redirect back with error message if the update fails
      return back()->with('error', 'Something went wrong.');
    }
  }

  /**
   * Remove the specified company policy from storage.
   *
   * @param  \Illuminate\Http\Request  $request The HTTP request object containing the ID of the company policy to be deleted
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Request $request)
  {
    // Find the company policy record by ID
    $item = CompanyPolicy::find($request->id);

    // Check if the company policy record exists
    if (empty($item)){
      // If the company policy record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Delete the associated image file
    self::deleteFile($item->file_url);

    // Log the delete action
    self::saveLog($item, $request, 'delete');

    // Attempt to delete the company policy record
    if ($item->delete()) {
      // If the deletion is successful, return a JSON response indicating success
      return response()->json(['ret' => 1, 'msg'=>'Successfully Deleted a Company Policy!', 'url'=>route('company')]);
    }
  }

  /**
   * Save log for company policy operations.
   *
   * @param  mixed  $item The company policy item being operated on
   * @param  mixed  $request The form that is being submitted
   * @param  string|null  $type The type of operation (insert, update, delete)
   * @param  string|null  $url The image URL
   * @return void
   */
  private static function saveLog($item, $request, $type, $url = null)
  {
    // Default log message and method
    $save = 1;
    $msg = 'Added new Company Policy:';
    $msg .= '<br>-------------------------------';
    $msg .= '<br><b>Title</b>: <i>'.$item->title.'</i>';
    $msg .= '<br><b>Subtitle</b>: <i>'.$item->subtitle.'</i>';
    $msg .= '<br><b>Status</b>: <i>'.$item->status.'</i>';
    $msg .= '<br><b>File</b>: <i>'.str_replace(asset('/storage/app/files/policy/'), '', $url).'</i>';
    $method = 'Insert';

    // Determine log message and method based on the operation type
    if ($type == 'update') {
      $save = 0;
      $msg = 'Company Policy Updated:';
      $msg .= '<br>-------------------------------';
      if ($item->title != $request->title) {
        $msg .= '<br><b>Title</b>: <i>'.$request->title.'</i>';
        $save = 1;
      }
      if ($item->subtitle != $request->subtitle) {
        $msg .= '<br><b>Subtitle</b>: <i>'.$request->subtitle.'</i>';
        $save = 1;
      }
      if ($item->status != $request->status) {
        $msg .= '<br><b>Status</b>: <i>'.$item->status.'</i>';
        $save = 1;
      }
      if ($item->file_url != $url) {
        $msg .= '<br><b>File</b>: <i>'.str_replace(asset('/storage/app/files/policy/'), '', $url).'</i>';
        $save = 1;
      }
      $method = 'Update';
    } else if($type == 'delete') {
      Log::where('module_id', $item->id)->where('module', 'Company')->delete();
      $save = 0;
    }

    // Check if $save is true
    if ($save) {
      // Create a new log instance
      $log = new Log();

      // Set log attributes
      $log->employee_id = Auth::user()->id;
      $log->module_id = $item->id;
      $log->module = 'Company';
      $log->method = $method;
      $log->message = $msg;

      // Save the log
      $log->save();
    }
  }

  /**
   * Delete the file associated with the given URL.
   *
   * @param  string  $url The URL of the file to be deleted
   * @return void
   */
  private static function deleteFile($url)
  {
    // Extract the relative path of the file
    $path = substr(str_replace(asset('/storage/app/files/'), '', $url), 1);

    // Check if the file exists and delete it
    if (file_exists(Storage::path('files/'.$path))) {
      unlink(Storage::path('files/'.$path));
    }
  }
}
