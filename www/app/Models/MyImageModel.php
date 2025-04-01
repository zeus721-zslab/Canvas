<?php namespace App\Models;

use App\Entities\MyImg;
use CodeIgniter\Model;

class MyImageModel extends Model
{
    protected $table = 'tb_cvs_myimg';
    protected $primaryKey = 'myimg_id';
    protected $returnType = MyImg::class;
    protected $allowedFields = [ 'user_id','image_file','w','h','reg_date' ];
    protected $validationRules = [
            'user_id'       => 'required'
        ,   'image_file'    => 'required'
        ,   'w'             => 'required'
        ,   'h'             => 'required'
        ,   'reg_date'      => 'required'
    ];

    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;

    public function getMyImageList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
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

        if(isset($arrayParams['user_id'])) {
            $whereQueryString .= " AND A.user_id = :user_id: ";
            $aBindParams['user_id'] = $arrayParams['user_id'];
        }

        if(empty($arrayParams['search_text']) == false){

            if(!isset($arrayParams['search_type']) || empty($arrayParams['search_type'])) {
                $whereQueryString .= " AND ( B.username LIKE :search_text_like: OR {$this->primaryKey} = :search_text: ) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }else if($arrayParams['search_type'] == 'keyword') {
                $whereQueryString .= " AND FIND_IN_SET(:search_text:, keyword) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
            } if(empty($arrayParams['search_type']) == false) {
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }

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
                        A.*
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

    public function getMyImageInfo(array $arrayParams) : array
    {

        $whereQueryString  = "";
        $aBindParams = [];
        if(isset($arrayParams[$this->primaryKey])) {
            $whereQueryString .= " AND {$this->primaryKey} = :{$this->primaryKey}: ";
            $aBindParams[$this->primaryKey] = $arrayParams[$this->primaryKey];
        }

        if(isset($arrayParams['user_id'])) {
            $whereQueryString .= " AND user_id = :user_id: ";
            $aBindParams['user_id'] = $arrayParams['user_id'];
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

