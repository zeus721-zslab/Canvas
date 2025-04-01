<?php namespace App\Models;

use App\Entities\MemberEn;
use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'tb_member';
    protected $primaryKey = 'member_id';
    protected $returnType = MemberEn::class;
    protected $allowedFields = [ 'name' , 'reg_date', 'mod_date'];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];

    public function getMemberInfo(array $arrayParams) : array
    {

        $whereQueryString  = " AND del_yn = 'N' ";

        if(isset($arrayParams['member_id'])) $whereQueryString .= " AND {$this->primaryKey} = '{$arrayParams['member_id']}' ";

        $sql = "SELECT 
                * 
                FROM {$this->table} 
                WHERE 1 {$whereQueryString}
        ";
        $oResult = $this->db->query($sql);
        $aResult = $oResult->getRowArray();


        return $aResult ?? [];

    }

}

