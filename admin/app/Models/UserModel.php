<?php namespace App\Models;

use App\Entities\User;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id';
    protected $returnType = User::class;
    protected $allowedFields = [
        's_use_date',
        'e_use_date',
        'memo'
    ];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;


    public function getUserList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams        = [];
        $whereQueryString   = "";
        $limitQueryString   = "";
        $orderbyQueryString = " ORDER BY {$this->primaryKey} DESC ";


        if(isset($arrayParams['search_text']) && $arrayParams['search_text']){

            if($arrayParams['search_type']){ //선택검색
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                //$aBindParams['search_type'] = $arrayParams['search_type'];
                $aBindParams['search_text_like'] = "%{$arrayParams['search_text']}%";
            }else{ //전체검색
                $whereQueryString .= " AND ( 
                        A.username LIKE :search_text_like:
                    OR  A.user_email LIKE :search_text_like: 
                    OR  A.cell_tel LIKE :search_text_like: 
                    OR  A.login_id LIKE :search_text_like:
                    OR  A.id LIKE :search_text_like:  
                )";
                $aBindParams['search_text_like'] = "%{$arrayParams['search_text']}%";
            }

        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] =  $s_limit;
            $aBindParams['e_limit'] =  $e_limit;
        }

        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt 
                    FROM {$this->table} A
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                    *
                    ,   (SELECT cs_memo FROM tb_user_extra B WHERE A.id = B.user_id ) AS cs_memo
                    FROM {$this->table} A
                    WHERE 1 
                    {$whereQueryString}
                    {$orderbyQueryString}
                    {$limitQueryString}
            ";

            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getResultArray();
        }

        return $aResult;

    }

    public function getUserInfo(array $arrayParams) : array
    {

        $whereQueryString  = "";
        $aBindParams = [];
        if(isset($arrayParams['id'])) {
            $whereQueryString .= " AND {$this->primaryKey} = :id: ";
            $aBindParams['id'] = $arrayParams['id'];
        }

        $sql = "SELECT 
                * 
                FROM {$this->table} 
                WHERE 1 {$whereQueryString};
        ";
        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getRowArray();

        return $aResult ?? [];

    }

}

