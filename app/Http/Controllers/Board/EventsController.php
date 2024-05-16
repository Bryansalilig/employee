<?php
/**
 * Controller for Board > Event
 *
 * This controller handles CRUD operations related to events on the board.
 *
 * @version 1.0
 * @since 2024-03-27
 *
 * Changes:
 * - 2024-03-27: File creation
 * - 2024-04-02:
 *    - Remove Sessions on construct()
 *    - Add Public Static Variables
 * - 2024-04-04:
 *    - Update Logging function
 */

// Declare the namespace for the controller
namespace App\Http\Controllers\Board;

// Import necessary classes for the controller
use App\Http\Controllers\Controller;
use App\Models\ElinkActivities;
use App\Models\Events;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

// Controller class definition
class EventsController extends Controller
{
  /**
   * @var array
   */
  public static $data = [];

  /**
   * @var void
   */
  public static $view = 'board.event';

  /**
   * Constructor method to set up session data.
   *
   * This method initializes session variables for view and menu navigation
   * within the Board > Event module.
   */
  public function __construct()
  {
    // Set variables for view and menu navigation
    self::$data['view'] = self::$view;
    self::$data['menu'] = 'board';
    self::$data['submenu'] = 'events';
  }

  /**
   * Method to display a listing of events.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    if (!Auth::user()->isAdmin()) {
      return redirect(route('events.calendar'));
    }

    // Retrieve all events ordered by event id
    self::$data['events'] = Events::orderByDesc('id')->get();

    // Return the view with event data
    return view(self::$view.'.index', self::$data);
  }

  /**
   * Show the form for creating a new event.
   *
   * @return \Illuminate\Contracts\View\View The view displaying the create event form.
   */
  public function create()
  {
    // Return the view for creating a new event with data
    return view(self::$view.'.create', self::$data);
  }

  /**
   * Store a newly created event.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Create a new instance of Events model
    $item = new Events();

    // Assign input values to the corresponding properties
    $item->event_name = $request->event_name;
    $item->event_description = $request->event_description;
    $item->event_color = $request->event_color;
    $item->start_date = $request->start_date;
    $item->end_date = $request->end_date;

    // Attempt to save the event record
    if ($item->save()) {
      // Save a log for the event
      self::saveLog($item, $request, 'insert');

      // Generate a unique slug for the event
      $first = strtotime(date('Y-m-d H:i:s'));
      $second = substr(md5($item->id) , -4);
      $third = substr(uniqid() , -4);
      $fourth = substr(rand() , -4);
      $fifth = generateRandomString();

      // Combine components to form the slug
      $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;

      // Update the slug property of the event
      $item->slug = $slug;
      $item->save();

      // Redirect to the newly created event
      return redirect(route('event.edit', ['slug' => $slug]))->with('success', 'Successfully Added a Event!');
    } else {
      // Redirect back with error message if saving fails
      return back()->with('error', 'Something went wrong.');
    }
  }

  /**
   * Display the form for editing the specified event.
   *
   * @param  string $slug The slug of the event to be edited
   * @return \Illuminate\Http\Response
   */
  public function edit($slug)
  {
    // Retrieve the event record based on the provided slug
    $item = Events::where('slug', $slug)->first();

    // Check if the event record exists
    if (empty($item)) {
      // If the event record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Pass the event data to the view
    self::$data['item'] = $item;

    // Retrieve logs related to the current event
    self::$data['logs'] = Log::getLog('Events', $item->id);

    // Load the edit view with the event data
    return view(self::$view.'.edit', self::$data);
  }

  /**
   * Update the specified event.
   *
   * @param  \Illuminate\Http\Request  $request The HTTP request object containing the updated event data
   * @param  int  $id The ID of the event to be updated
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // Find the event record by ID
    $item = Events::find($id);

    // Check if the event record exists
    if (empty($item)){
      // If the event record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Copy data from item to keep the original
    $old = Events::find($id);

    // Update event data with the values from the request
    $item->event_name = $request->event_name;
    $item->start_date = $request->start_date;
    $item->end_date = $request->end_date;
    $item->event_color = $request->event_color;
    $item->event_description = $request->event_description;

    // Save the updated event record
    if ($item->save()) {
      // Log the update action
      self::saveLog($old, $request, 'update');

      // Redirect back with success message upon successful update
      return back()->with('success', 'Successfully Update an Event!');
    } else {
      // Redirect back with error message if the update fails
      return back()->with('error', 'Something went wrong.');
    }
  }

  /**
   * Remove the specified event.
   *
   * @param  \Illuminate\Http\Request  $request The HTTP request object containing the ID of the event to be deleted
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Request $request)
  {
    // Find the event record by ID
    $item = Events::find($request->id);

    // Check if the event record exists
    if (empty($item)){
      // If the event record does not exist, redirect to the 404 page
      return redirect(url('404'));
    }

    // Log the delete action
    self::saveLog($item, $request, 'delete');

    // Attempt to delete the event record
    if ($item->delete()) {
      // If the deletion is successful, return a JSON response indicating success
      return response()->json(['ret' => 1, 'msg'=>'Successfully Deleted an Event!', 'url'=>route('events')]);
    }
  }

  /**
   * Calendar Page.
   *
   * @return \Illuminate\Contracts\View\View The view displaying the calendar data.
   */
  public function calendar()
  {
    // Pass the event data to the view
    self::$data['events'] = self::eventData();

    // Load the calendar with the events data
    return view(self::$view.'.calendar', self::$data);
  }

  /**
   * Save log for events operations.
   *
   * @param  mixed  $item The events item being operated on
   * @param  mixed  $request The form that is being submitted
   * @param  string|null  $type The type of operation (insert, update, delete)
   * @param  string|null  $url The image URL
   * @return void
   */
  private static function saveLog($item, $request, $type)
  {
    // Default log message and method
    $save = 1;
    $msg = 'Added new Event:';
    $msg .= '<br>-------------------------------';
    $msg .= '<br><b>Event Name</b>: <i>'.$item->event_name.'</i>';
    $msg .= '<br><b>Start Date</b>: <i>'.$item->start_date.'</i>';
    $msg .= '<br><b>End Date</b>: <i>'.$item->end_date.'</i>';
    $msg .= '<br><b>Event Color</b>: <div class="d-inline-block align-middle" style="background-color: '.$item->event_color.'; width: 20px; height: 20px;"></div>';
    if ($request->event_description) { $msg .= '<br><b>Event Description</b>: <i>'.stringLimit($request->event_description).'</i>'; }
    $method = 'Insert';

    // Determine log message and method based on the operation type
    if ($type == 'update') {
      $save = 0;
      $msg = 'Event Updated:';
      $msg .= '<br>-------------------------------';
      if ($item->event_name != $request->event_name) {
        $msg .= '<br><b>Event Name</b>: <i>'.$request->event_name.'</i>';
        $save = 1;
      }
      if (date('Y-m-d H:i', strtotime($item->start_date)) != $request->start_date) {
        $msg .= '<br><b>Start Date</b>: <i>'.$request->start_date.'</i>';
        $save = 1;
      }
      if (date('Y-m-d H:i', strtotime($item->end_date)) != $request->end_date) {
        $msg .= '<br><b>End Date</b>: <i>'.$request->end_date.'</i>';
        $save = 1;
      }
      if ($item->event_color != $request->event_color) {
        $msg .= '<br><b>Event Color</b>: <div class="d-inline-block align-middle" style="background-color: '.$request->event_color.'; width: 20px; height: 20px;"></div>';
        $save = 1;
      }
      if ($item->event_description != $request->event_description) {
        $msg .= '<br><b>Event Description</b>: <i>'.stringLimit($request->event_description).'</i>';
        $save = 1;
      }
      $method = 'Update';
    } else if($type == 'delete') {
      Log::where('module_id', $item->id)->where('module', 'Events')->delete();
      $save = 0;
    }

    // Check if $save is true
    if ($save) {
      // Create a new log instance
      $log = new Log();

      // Set log attributes
      $log->employee_id = Auth::user()->id;
      $log->module_id = $item->id;
      $log->module = 'Events';
      $log->method = $method;
      $log->message = $msg;

      // Save the log
      $log->save();
    }
  }

  /**
   * Data that will be showing on the Calendar Page
   *
   * @return array of items
   */
  private function eventData()
  {
    // Convert objects to Collection instances

    // Get all Events
    $events = new Collection(Events::all());

    // Get all Activities
    $activities = new Collection(ElinkActivities::all());

    // Merge the collections
    $combinedData = $events->merge($activities);

    // Convert the merged collection back to an object
    $data = $combinedData->all();

    // Create a variable array $items
    $items = [];

    // Iterate through each item
    foreach ($data as $key => $item) {
      // Add data to the $item array
      $items[$key] = [
        'slug' => $item['slug'],
        'title' => $item['event_name'] ?? $item['title'],
        'event_color' => $item['event_color'] ?? '#a38e14',
        'event_description' => $item['event_description'] ?? $item['message'],
        'start' => $item['start_date'] ?? $item['activity_date'],
        'end' => $item['end_date'] ?? $item['activity_date'],
        'subtitle' => $item['subtitle'],
        'image_url' => $item['image_url'] ?? 'none',
      ];
    }

    // Return the constructed $item array
    return $items;
  }
}

