<?php 
// FileUploaded.php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
}


?>