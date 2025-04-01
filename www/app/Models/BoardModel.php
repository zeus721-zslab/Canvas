<?php namespace App\Models;

use App\Entities\Order;
use CodeIgniter\Model;

class BoardModel extends Model
{
    protected $table = 'tb_board';
    protected $primaryKey = 'board_id';
    protected $returnType = Order::class;
    protected $allowedFields = [];
    protected $validationRules = [];
    protected $skipValidation = false;
    protected $validationMessages = [];


    public function getBoardList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams        = [];
        $whereQueryString   = " AND del_yn = 'N' ";
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

        if(empty($arrayParams['type']) == false){
            $whereQueryString .= " AND type = :type: ";
            $aBindParams['type'] =  $arrayParams['type'];
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
                    , (SELECT COUNT(*) FROM tb_files B WHERE B.parent_id = A.board_id AND B.loc = 'notice' AND del_yn = 'N' ) AS file_cnt
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

    public function getOrderInfo(array $arrayParams) : array
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

