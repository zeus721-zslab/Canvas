<?php namespace App\Models;

use App\Entities\ActionLog;
use CodeIgniter\Model;

class ActionLogModel extends Model
{
    protected $table = 'tb_action_log';
    protected $primaryKey = 'alog_id';
    protected $returnType = ActionLog::class;
    protected $allowedFields = ['type','template_id','my_canvas_id','clip_id','reg_id','reg_ip','reg_date'];
    protected $validationRules = [];
    protected $skipValidation = false;
    protected $validationMessages = [];

    public function refOrderCancelData($arrayParams) : array
    {

        $aBindParams        = [];
        $whereQueryString   = "";

        if(isset($arrayParams['user_id']) && !empty($arrayParams['user_id'])){
            $whereQueryString .= " AND A.reg_id = :user_id:";
            $aBindParams['user_id'] = $arrayParams['user_id'];
        }
        if(isset($arrayParams['s_date']) && !empty($arrayParams['s_date'])){
            $whereQueryString .= " AND A.reg_date >= :s_date:";
            $aBindParams['s_date'] = $arrayParams['s_date'].'000000';
        }
        if(isset($arrayParams['e_date']) && !empty($arrayParams['e_date'])){
            $whereQueryString .= " AND A.reg_date <= :e_date:";
            $aBindParams['e_date'] = $arrayParams['e_date'].'235959';
        }

        $sql = "SELECT 
                    SUM((SELECT COUNT(*) FROM tb_clip B WHERE A.clip_id = B.clip_id AND B.paid_yn = 'Y')) AS clip_cnt
                ,   SUM((SELECT COUNT(*) FROM tb_cvs_template C WHERE C.template_id = A.template_id AND C.paid_yn = 'Y')) AS template_cnt
                ,   SUM((SELECT COUNT(*) FROM tb_cvs_mycvs D WHERE D.my_canvas_id = A.my_canvas_id)) AS mycvs_cnt
                FROM {$this->table} A
                WHERE 1
                {$whereQueryString}
        ";

        return $this->db->query($sql , $aBindParams)->getRowArray();
    }


}

