<?php
/**
 * Controller for Board > Banner
 *
 * This controller handles CRUD operations related to banner on the board.
 *
 * @version 1.0
 * @since 2024-04-20
 *
 * Changes:
 * - 2024-04-20: File creation
 */

// Declare the namespace for the controller
namespace App\Http\Controllers\Board;

// Import necessary classes for the controller
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Controller class definition
class BannerController extends Controller
{
  /**
   * @var array
   */
  public static $data = [];

  /**
   * @var void
   */
  public static $view = 'board.banner';

  /**
   * Constructor method to set up session data.
   *
   * This method initializes session variables for view and menu navigation
   * within the Board > Activity module.
   */
  public function __construct()
  {
    // Set variables for view and menu navigation
    self::$data['view'] = self::$view;
    self::$data['menu'] = 'board';
    self::$data['submenu'] = 'banner';
  }

  /**
   * Method to display a listing of banners.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    // Retrieve all banner ordered by created date
    self::$data['items'] = Banner::orderBy('created_at', 'DESC')->get();

    // Return the view with activity data
    return view(self::$view.'.index', self::$data);
  }

  /**
   * Show the form for creating a new banner.
   *
   * @return \Illuminate\Contracts\View\View The view displaying the create banner form.
   */
  public function create()
  {
    // Return the view for creating a new banner with data
    return view(self::$view.'.create', self::$data);
  }

  /**
   * Store a newly created banner in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Create a new instance of Banner model
    $item = new Banner();

    // Assign input values to the corresponding properties
    $item->created_by = Auth::user()->id;
    $item->title = $request->title;
    $item->status = $request->status;

    // Create a variable $url
    $url = '';

    // Check if image is uploaded
    if ($request->hasFile("image_url")) {
      // Generate a unique filename for the image
      $filename = time() . '_' . uniqid() . '.' . $request->image_url->getClientOriginalExtension();

      // Save the image to the storage disk
      $path = Storage::disk('images')->putFileAs("banner", $request->image_url, $filename);

      // Update the $url property with the asset path
      $url = asset('storage/app/images/' . $path);

      // Update the image URL with the $url
      $item->image_url =  $url;
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
      return redirect(route('banner.edit', ['slug' => $slug]))->with('success', 'Successfully Added a Banner!');
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
    $item = Banner::where('slug', $slug)->first();

    // Check if the banner record exists
    if (empty($item)) {
      // If the banner record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Pass the banner data to the view
    self::$data['item'] = $item;

    // Retrieve logs related to the current banner
    self::$data['logs'] = Log::getLog('Banner', $item->id);

    // Load the edit view with the banner data
    return view(self::$view.'.edit', self::$data);
  }

  /**
   * Update the specified banner in storage.
   *
   * @param  \Illuminate\Http\Request  $request The HTTP request object containing the updated banner data
   * @param  int  $id The ID of the banner to be updated
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // Find the banner record by ID
    $item = Banner::find($id);

    // Check if the banner record exists
    if (empty($item)){
      // If the banner record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Copy data from item to keep the original
    $old = Banner::find($id);

    // Update activity data with the values from the request
    $item->title = $request->title;
    $item->status = $request->status;

    // Create a variable $url
    $url = $item->image_url;

    // Check if image is uploaded
    if ($request->hasFile("image_url")) {
      // Delete the previous image associated with the banner
      self::deleteImage($item->image_url);

      // Generate a unique filename for the new image
      $filename = time() . '_' . uniqid() . '.' . $request->image_url->getClientOriginalExtension();

      // Store the new image in the designated directory
      $path = Storage::disk('images')->putFileAs("banner", $request->image_url, $filename);

      // Update the $url property with the asset path
      $url = asset('storage/app/images/' . $path);

      // Update the image URL with the $url
      $item->image_url =  $url;
    }

    // Save the updated banner record
    if ($item->save()) {
      // Log the update action
      self::saveLog($old, $request, 'update', $url);

      // Redirect back with success message upon successful update
      return back()->with('success', 'Successfully Updated the Banner!');
    } else {
      // Redirect back with error message if the update fails
      return back()->with('error', 'Something went wrong.');
    }
  }

  /**
   * Remove the specified banner from storage.
   *
   * @param  \Illuminate\Http\Request  $request The HTTP request object containing the ID of the banner to be deleted
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Request $request)
  {
    // Find the banner record by ID
    $item = Banner::find($request->id);

    // Check if the banner record exists
    if (empty($item)){
      // If the banner record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Delete the associated image file
    self::deleteImage($item->image_url);

    // Log the delete action
    self::saveLog($item, $request, 'delete');

    // Attempt to delete the banner record
    if ($item->delete()) {
      // If the deletion is successful, return a JSON response indicating success
      return response()->json(['ret' => 1, 'msg'=>'Successfully Deleted a Banner!', 'url'=>route('banner')]);
    }
  }

  /**
   * Save log for banner operations.
   *
   * @param  mixed  $item The banner item being operated on
   * @param  mixed  $request The form that is being submitted
   * @param  string|null  $type The type of operation (insert, update, delete)
   * @param  string|null  $url The image URL
   * @return void
   */
  private static function saveLog($item, $request, $type, $url = null)
  {
    // Default log message and method
    $save = 1;
    $msg = 'Added new Banner:';
    $msg .= '<br>-------------------------------';
    $msg .= '<br><b>Title</b>: <i>'.$item->title.'</i>';
    $msg .= '<br><b>Status</b>: <i>'.(($item->status) ? 'Active' : 'Inactive').'</i>';
    $msg .= '<br><b>Image</b>: <i>'.str_replace(asset('/storage/app/images/activities/'), '', $url).'</i>';
    $method = 'Insert';

    // Determine log message and method based on the operation type
    if ($type == 'update') {
      $save = 0;
      $msg = 'Banner Updated:';
      $msg .= '<br>-------------------------------';
      if ($item->title != $request->title) {
        $msg .= '<br><b>Title</b>: <i>'.$request->title.'</i>';
        $save = 1;
      }
      if ($item->status != $request->status) {
        $msg .= '<br><b>Status</b>: <i>'.(($request->status) ? 'Active' : 'Inactive').'</i>';
        $save = 1;
      }
      if ($item->image_url != $url) {
        $msg .= '<br><b>Image</b>: <i>'.str_replace(asset('/storage/app/images/activities/'), '', $url).'</i>';
        $save = 1;
      }
      $method = 'Update';
    } else if($type == 'delete') {
      Log::where('module_id', $item->id)->where('module', 'Banner')->delete();
      $save = 0;
    }

    // Check if $save is true
    if ($save) {
      // Create a new log instance
      $log = new Log();

      // Set log attributes
      $log->employee_id = Auth::user()->id;
      $log->module_id = $item->id;
      $log->module = 'Banner';
      $log->method = $method;
      $log->message = $msg;

      // Save the log
      $log->save();
    }
  }

  /**
   * Delete the image file associated with the given URL.
   *
   * @param  string  $url The URL of the image file to be deleted
   * @return void
   */
  private static function deleteImage($url)
  {
    // Extract the relative path of the image file
    $path = substr(str_replace(asset('/storage/app/images/'), '', $url), 1);

    // Check if the file exists and delete it
    if (file_exists(Storage::path('images/'.$path))) {
      unlink(Storage::path('images/'.$path));
    }
  }
}
