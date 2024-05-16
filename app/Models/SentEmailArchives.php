<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentEmailArchives extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "sent_email_archives";

}
