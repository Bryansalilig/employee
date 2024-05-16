<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;
    protected $table = 'elink_referral';

    public function getReferralFullName(){
        return $this->referral_first_name . ' ' . $this->referral_middle_name . ' ' . $this->referral_last_name;
    }
    public function getReferrerFullName(){
        return $this->referrer_first_name . ' ' . $this->referrer_middle_name . ' ' . $this->referrer_last_name;
    }
}
