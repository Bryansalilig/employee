<?php

namespace App\Models;

use App\Helpers\DateHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveCredits extends Model
{
    protected $table = 'leave_credits';

    protected $fillable = [
        'employee_id', 'credit', 'type', 'month', 'year', 'leave_id'
    ];

    public function leaveCredits()
    {
        $obj = DB::select("
            SELECT 
                *
            FROM
                employee_info
            WHERE
                status = 1 AND deleted_at IS NULL
                    AND eid LIKE 'ESCC-%';
        ");

        foreach($obj as $e):
            $id = $e->id;
            $det = DB::select("
                SELECT 
                    id
                FROM
                    leave_credits
                WHERE
                    employee_id = $id AND type = 1
                        AND month = ".date('m')."
                        AND year = ".date('Y').";
            ");
            if(count($det) == 0){
                $position = $this->getPosition($e->employee_category, $e->position_name);
                $new_date = date('Y-m-01', strtotime($e->hired_date));
                $dates = $this->computeYearDifference($new_date);
                $credits = $this->getLeaveCredits($position, $dates);

                $credit = new LeaveCredits();
                $credit->employee_id = $id;
                $credit->credit = $credits / 12;
                $credit->type = 1;
                $credit->month = date("n");
                $credit->year = date("Y");
                $credit->save();
            }
        endforeach;

        echo 'finish na';
        return;
    }

    public function creditValue($in_id)
    {
        $user = User::withTrashed()->find($in_id);
        $position = self::getPosition($user->employee_category, $user->position_name);
        $date = self::getDate($position) ? date('Y-m-01', strtotime($user->hired_date)) : date('Y-m-d', strtotime($user->hired_date));
        $dates = self::computeYearDifference($date);
        $credits = self::getLeaveCredits($position, $dates);
        $different_in_months = DateHelper::getDifferentMonths(date('Y-m-01', strtotime($date)));
        $credit_accrued = self::where('year', date('Y'))->where('employee_id', $in_id)->where('month', '<>', 0)->get();
        $credit = 0;
        foreach($credit_accrued as $cr) {
            if($cr->type == 1 && $cr->month != date('n')) { $credit += $cr->credit; }
        }
        $proper_credit = $credit + ($credits / 12);

        $data['position'] = $position;
        $data['date'] = $date;
        $data['dates'] = $dates;
        $data['credits'] = $proper_credit;

        return (object) $data;
    }

    private static function getPosition($in_category, $in_position)
    {
        $position = '';
        if($in_category == 4) {
            $position = 'Regular';
            if (strpos($in_position, 'SME') !== false) { $position = 'SME'; }

            if (strpos($in_position, 'Developmental Coach') !== false) { $position = 'Developmental Coach'; }

            if (strpos($in_position, 'Trainer') !== false) { $position = 'Trainer'; }
        } else if($in_category == 2) {
            $position = 'Supervisor';

            if (strpos($in_position, 'Manager') !== false) { $position = 'Associate Manager'; }

            if (strpos($in_position, 'Senior') !== false) { $position = 'Senior Supervisor'; }
        } else {
            $position = 'Manager';

            if (strpos($in_position, 'Senior') !== false) { $position = 'Senior Manager'; }
        }

        return $position;
    }

    private static function getDate($in_position)
    {
        $position = true;
        if($in_position === 'Regular' || $in_position === 'Supervisor' || $in_position === 'Manager') {
            $position = false;
        }

        return $position;
    }

    private static function computeYearDifference($in_date)
    {
        $carbonDate1 = Carbon::parse($in_date);
        $carbonDate2 = Carbon::now();

        $interval = $carbonDate1->diff($carbonDate2);

        $yearsDifference = $interval->y;
        $monthsDifference = $interval->m;

        return ['years' => $yearsDifference, 'months' => $monthsDifference];
    }

    private static function getCategory($in_category)
    {
        $category = '';
        switch($in_category):
            case 1: $category = 'Manager'; break;
            case 2: $category = 'Supervisor'; break;
            case 3: $category = 'Support'; break;
            case 4: $category = 'Rank'; break;
        endswitch;

        return $category;
    }

    private static function getLeaveCredits($in_position, $in_date)
    {
        $credit = 0;
        if($in_position == 'Regular') {
            $credit = 10;
            if($in_date['years'] == 3) { $credit = $credit + 1;  }
            if($in_date['years'] == 4) { $credit = $credit + 2;  }
            if($in_date['years'] == 5) { $credit = $credit + 3;  }
            if($in_date['years'] == 6) { $credit = $credit + 4;  }
            if($in_date['years'] >= 7) { $credit = $credit + 5;  }
        }

        if($in_position == 'SME' || $in_position == 'Developmental Coach' || $in_position == 'Trainer') {
            $credit = 10;
            if($in_date['years'] == 3) { $credit = $credit + 1;  }
            if($in_date['years'] == 4) { $credit = $credit + 2;  }
            if($in_date['years'] == 5) { $credit = $credit + 3;  }
            if($in_date['years'] == 6) { $credit = $credit + 4;  }
            if($in_date['years'] >= 7) { $credit = $credit + 5;  }
        }

        if($in_position == 'Supervisor' || $in_position == 'Associate Manager' || $in_position == 'Senior Supervisor') {
            $credit = 14;
            if($in_date['years'] == 3) { $credit = $credit + 1;  }
            if($in_date['years'] == 4) { $credit = $credit + 2;  }
            if($in_date['years'] == 5) { $credit = $credit + 3;  }
            if($in_date['years'] == 6) { $credit = $credit + 4;  }
            if($in_date['years'] >= 7) { $credit = $credit + 5;  }
        }

        if($in_position == 'Manager' || $in_position == 'Senior Manager') {
            $credit = 20;
            if($in_date['years'] == 3) { $credit = $credit + 1;  }
            if($in_date['years'] == 4) { $credit = $credit + 2;  }
            if($in_date['years'] == 5) { $credit = $credit + 3;  }
            if($in_date['years'] == 6) { $credit = $credit + 4;  }
            if($in_date['years'] >= 7) { $credit = $credit + 5;  }
        }

        return $credit;
    }
}
