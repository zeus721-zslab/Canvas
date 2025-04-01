<?php namespace App\Models;

use App\Entities\Goods;
use CodeIgniter\Model;

class GoodsModel extends Model
{
    protected $table = 'tb_goods';
    protected $primaryKey = 'good_id';
    protected $returnType = Goods::class;
    protected $allowedFields = [ 'good_name' , 'good_amount', 'use_flag' , 'reg_date' , 'reg_id' , 'reg_ip' , 'mod_date' , 'mod_id' , 'mod_ip' ];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];

    public function getGoodsInfo(array $arrayParams) : array
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

