<?php namespace App\Models;

use App\Entities\Qna;
use CodeIgniter\Model;

class QnaModel extends Model
{
    protected $table = 'tb_qna';
    protected $primaryKey = 'qna_id';
    protected $returnType = Qna::class;
    protected $allowedFields = ['user_id','title','content','del_yn','del_date','reg_id','reg_ip','reg_date','mod_id','mod_ip','mod_date'];
    protected $validationRules = [];
    protected $skipValidation = false;
    protected $validationMessages = [];


    public function getQnaList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams        = [];
        $whereQueryString   = "";
        $limitQueryString   = "";
        $orderbyQueryString = " ORDER BY {$this->primaryKey} DESC ";

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] =  $s_limit;
            $aBindParams['e_limit'] =  $e_limit;
        }

        if(empty($arrayParams['search_text']) == false){

            if(!isset($arrayParams['search_type']) || empty($arrayParams['search_type'])) {
                $whereQueryString .= " AND ( title LIKE :search_text_like: OR content LIKE :search_text_like: ) ";
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            } if(empty($arrayParams['search_type']) == false) {
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }

        }

        if(empty($arrayParams['user_id']) == false){
            $whereQueryString .= " AND user_id = :user_id: ";
            $aBindParams['user_id'] =  $arrayParams['user_id'];
        }

        if(empty($arrayParams['del_yn']) == false){
            $whereQueryString .= " AND del_yn = :del_yn: ";
            $aBindParams['del_yn'] =  $arrayParams['del_yn'];
        }

        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt
                    FROM {$this->table}
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                    *
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

    public function getQnaInfo(array $arrayParams) : array
    {

        $whereQueryString  = "";
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

