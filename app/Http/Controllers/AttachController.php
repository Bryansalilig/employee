<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachController extends Controller {

   public function download($key, $idx)
   {
      $file = File::where('id', $idx)->where('file_key', $key)->first();

      if (!empty($file) && file_exists(public_path("uploads\\".$file->file_name))) {
         header('Content-Description: File Transfer');
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename="'.$file->orig_name.'"');
         header('Expires: 0');
         header('Cache-Control: must-revalidate');
         header('Pragma: public');
         header('Content-Length: '.filesize(public_path("uploads\\".$file->file_name)));
         flush();
         readfile(public_path("uploads\\".$file->file_name));

         return;
      }
   }

   public function remove(Request $request)
   {
      $file = File::where('id', $request->form_idx)->where('file_key', $request->form_key)->first();

      if (!empty($file) && file_exists(public_path("uploads\\".$file->file_name))) {
         $file->delete();

         unlink(public_path("uploads\\".$file->file_name));
      }

      echo json_encode(array('result'=>1));
   }

   public function add(Request $request) {
     ini_set('memory_limit', '-1');
     ini_set('max_execution_time', '-1');
echo '<pre>';
print_r($request->all());
return;
      $uploaded_files = $this->upload($request->file('form-file'));

      if (empty($uploaded_files)) {
         echo json_encode(array)();
         return;
      }

      $files = [];
      foreach ($uploaded_files as $uploaded_file) {
         $file = new File();
         $file->category = $request->input('form-category');
         $file->file_key = $request->input('form-key');
         $file->file_name = $uploaded_file->file_name;
         $file->file_path = $uploaded_file->orig_path;
         $file->file_url = $uploaded_file->url;
         $file->file_type = $uploaded_file->type;
         $file->file_size = $uploaded_file->size;
         $file->orig_name = $uploaded_file->orig_name;
         $file->save();

         $files[] = array($file->id=>array('url'=>$uploaded_file->url, 'id'=>$file->id, 'name'=>$uploaded_file->orig_name));
      }

      echo stripslashes(json_encode($files));
   }

   private function upload($in_files)
   {
      $uploaded_files = array();

      foreach($in_files as $file) {
         $extension = $request->file('file')->guessExtension();
         $path = Storage::disk('public')->putFileAs("uploads", $file, $file->getFilename());

         $file->orig_name = $file->getClientOriginalName();
         $file->orig_extension = $file->getClientOriginalExtension();
         $file->orig_path = $file->getRealPath();
         $file->size = $file->getSize();
         $file->type = $file->getMimeType();
         $file->file_path = 'public/';
         $file->file_name = $file->getFilename();
         $file->url = 'public/'.$file->getFilename();

         // $file->move('./uploads', $file->getFilename());

      $uploaded_files[] = $file;
      }

      return $uploaded_files;
   }
}
