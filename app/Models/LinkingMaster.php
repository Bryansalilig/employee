<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Valuestore\Valuestore;
use App\Models\LinkingTypes;
use App\Models\LinkingFocus;
use App\Models\QuickLink;
use App\Models\CementingExpectations;
use App\Models\AccountabilitySession;
use App\Models\SkillsDevelopment;
use App\Models\SkillBuilding;
use App\Models\GoalSetting;
use App\Models\GettingToKnowYou;
use App\Models\User;

class LinkingMaster extends Model
{
    protected $table = 'linking_master';

    protected $primaryKey = 'lnk_id';
    
    protected $fillable = [
        'lnk_date', 'lnk_linker', 'lnk_linkee', 'lnk_type', 'lnk_acknw'
    ];

    private static function populate($data)
    {
        $list = [];
        foreach($data as $key=>$lm) {
            $lm->focus = '---';
            switch(intval($lm->lnk_type)) {
                case 1:
                    $ql = QuickLink::getSession($lm->lnk_id);

                    if(!empty($ql)) {
                        $lm->focus = $ql->fc_desc;
                        $lm->button = 'QL';

                        $list[$key] = $lm;
                    }
                    break;
                case 2:
                    $ce = CementingExpectations::getSession(sha1($lm->lnk_id));

                    if(!empty($ce)) {
                        $lm->focus = $ce->fc_desc;
                        $lm->lnk_id = $ce->se_com_id;
                        $lm->button = 'CE';

                        $list[$key] = $lm;
                    }
                    break;
                case 3:
                    $as = AccountabilitySession::getSession(sha1($lm->lnk_id));

                    if(!empty($as)) {
                        $lm->focus = $as->fc_desc;
                        $lm->lnk_id = $as->ac_com_id;
                        $lm->button = 'AS';

                        $list[$key] = $lm;
                    }
                    break;
                case 4:
                    $sda = SkillsDevelopment::getSession(sha1($lm->lnk_id));

                    if(!empty($sda)) {
                        $lm->focus = $sda->sda_type_desc;
                        $lm->lnk_id = $sda->sda_com_id;
                        $lm->button = 'SDA';

                        $list[$key] = $lm;
                    }
                    break;
                case 5:
                    $gtky = GettingToKnowYou::getSession(sha1($lm->lnk_id));

                    if(!empty($gtky)) {
                        $lm->lnk_id = $gtky->gtk_com_num;
                        $lm->button = 'GTKY';

                        $list[$key] = $lm;
                    }
                    break;
                case 6:
                    $sb = SkillBuilding::getSession(sha1($lm->lnk_id));

                    if(!empty($sb)) {
                        $lm->focus = $sb->fc_desc;
                        $lm->lnk_id = $sb->sb_com_num;
                        $lm->button = 'SB';

                        $list[$key] = $lm;
                    }
                    break;
                case 7:
                    $gs = GoalSetting::getSession(sha1($lm->lnk_id));

                    if(!empty($gs)) {
                        $lm->lnk_id = $gs->gs_com_id;
                        $lm->button = 'GS';

                        $list[$key] = $lm;
                    }
                    break;
            }
        }

        return $list;
    }

    public static function getPending($id)
    {
        $data = DB::select("
            SELECT
                `linking_master`.*,
                `linking_types`.`lt_desc`,
                `linking_types`.`lt_link`,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`
            FROM
                `linking_master`
            INNER JOIN 
                `linking_types`
            ON 
                `linking_types`.`lt_id` = `linking_master`.`lnk_type`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linkee`
            WHERE
                `linking_master`.`lnk_linker` = {$id} AND
                `linking_master`.`lnk_acknw` = 0 AND
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1
            ORDER BY 
                `linking_master`.`created_at`
            DESC
        ");

        return static::populate($data);
    }

    public static function getUnacknowledged($id)
    {
        $data = DB::select("
            SELECT
                `linking_master`.*,
                `linking_types`.`lt_desc` AS 'link_type_desc',
                `linking_types`.`lt_link`,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`
            FROM
                `linking_master`
            INNER JOIN 
                `linking_types`
            ON 
                `linking_types`.`lt_id` = `linking_master`.`lnk_type`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linker`
            WHERE
                `linking_master`.`lnk_linkee` = {$id} AND
                `linking_master`.`lnk_acknw` = 0 AND
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1
            ORDER BY 
                `linking_master`.`lnk_date`
            DESC
        ");

        return static::populate($data);
    }

    public static function getPersonal($id)
    {
        $data = DB::select("
            SELECT
                `linking_master`.*,
                `linking_types`.`lt_desc` AS 'link_type_desc',
                `linking_types`.`lt_link`,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`
            FROM
                `linking_master`
            INNER JOIN 
                `linking_types`
            ON 
                `linking_types`.`lt_id` = `linking_master`.`lnk_type`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linker`
            WHERE
                `linking_master`.`lnk_linkee` = {$id} AND
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1
            ORDER BY 
                `linking_master`.`lnk_date`
            DESC
        ");

        return static::populate($data);
    }

    public static function getReport($id = null)
    {
        $sql = '';
        if(!empty($id)) {
            $sql = "AND `linking_master`.`lnk_linker` = {$id}";
        }

        $data = DB::select("
            SELECT
                `linking_master`.*,
                `linking_types`.`lt_desc`,
                `linking_types`.`lt_link`
            FROM
                `linking_master`
            INNER JOIN 
                `linking_types`
            ON 
                `linking_types`.`lt_id` = `linking_master`.`lnk_type`
            WHERE
                `linking_master`.`lnk_status` = 1
                {$sql}
            ORDER BY 
                `linking_master`.`lnk_date`
            DESC
        ");

        $list = [];
        foreach($data as $key=>$lm) {
            $linker = User::withTrashed()->find($lm->lnk_linker);
            $linkee = User::withTrashed()->find($lm->lnk_linkee);

            $lm->status = ($lm->lnk_acknw) ? 'Acknowledged' : 'Pending';
            $lm->focus = '---';
            $lm->comments = '---';

            if(!empty($linker) && !empty($linkee)) {
                $lm->linker = $linker->fullName2();
                $lm->linkee = $linkee->fullName2();
                $lm->linkee_number = $linkee->eid;
            }

            switch(intval($lm->lnk_type)) {
                case 1:
                    $ql = QuickLink::getSession($lm->lnk_id);

                    if(!empty($ql)) {
                        $lm->focus = $ql->fc_desc;
                        $lm->comments = $ql->rf_comments;
                        $lm->link = url("{$lm->lt_link}/{$ql->rf_lnk_id}");

                        $list[$key] = $lm;
                    }
                    break;
                case 2:
                    $ce = CementingExpectations::getSession(sha1($lm->lnk_id));

                    if(!empty($ce)) {
                        $lm->focus = $ce->fc_desc;
                        $lm->comments = $ce->se_comments;
                        $lm->link = url("{$lm->lt_link}/{$ce->se_com_id}");

                        $list[$key] = $lm;
                    }
                    break;
                case 3:
                    $as = AccountabilitySession::getSession(sha1($lm->lnk_id));

                    if(!empty($as)) {
                        $lm->focus = $as->fc_desc;
                        $lm->comments = $as->ac_comments;
                        $lm->link = url("{$lm->lt_link}/{$as->ac_com_id}");

                        $list[$key] = $lm;
                    }
                    break;
                case 4:
                    $sda = SkillsDevelopment::getSession(sha1($lm->lnk_id));

                    if(!empty($sda)) {
                        $lm->focus = $sda->sda_type_desc;
                        $lm->comments = $sda->sda_comments;
                        $lm->link = url("{$lm->lt_link}/{$sda->sda_com_id}");

                        $list[$key] = $lm;
                    }
                    break;
                case 5:
                    $gtky = GettingToKnowYou::getSession(sha1($lm->lnk_id));

                    if(!empty($gtky)) {
                        $lm->comments = $gtky->gtk_others;
                        $lm->link = url("{$lm->lt_link}/{$gtky->gtk_com_num}");

                        $list[$key] = $lm;
                    }
                    break;
                case 6:
                    $sb = SkillBuilding::getSession(sha1($lm->lnk_id));

                    if(!empty($sb)) {
                        $lm->focus = $sb->fc_desc;
                        $lm->comments = $sb->sb_feedback;
                        $lm->link = url("{$lm->lt_link}/{$sb->sb_com_num}");

                        $list[$key] = $lm;
                    }
                    break;
                case 7:
                    $gs = GoalSetting::getSession(sha1($lm->lnk_id));

                    if(!empty($gs)) {
                        $lm->comments = $gs->gs_feedback;
                        $lm->link = url("{$lm->lt_link}/{$gs->gs_com_id}");

                        $list[$key] = $lm;
                    }
                    break;
            }
        }

        return $list;
    }
}
