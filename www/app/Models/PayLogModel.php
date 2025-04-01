<?php namespace App\Models;

use App\Entities\Paylog;
use CodeIgniter\Model;

class PayLogModel extends Model
{
    protected $table = 'tb_kcp_log';
    protected $primaryKey = 'log_id';
    protected $returnType = Paylog::class;
    protected $allowedFields = ['order_id','data','type','reg_date'];
    protected $validationRules = [];
    protected $skipValidation = false;
    protected $validationMessages = [];

    public function getLogInfo(array $arrayParams) : array
    {

        $whereQueryString  = " ";
        $aBindParams = [];
        if(isset($arrayParams[$this->primaryKey])) {
            $whereQueryString .= " AND {$this->primaryKey} = :{$this->primaryKey}: ";
            $aBindParams[$this->primaryKey] = $arrayParams[$this->primaryKey];
        }

        $sql = "SELECT 
                * 
                FROM {$this->table} 
                WHERE 1 {$whereQueryString}
        ";
        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getRowArray();


        return $aResult ?? [];

    }

}

