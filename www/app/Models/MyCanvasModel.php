<?php namespace App\Models;

use App\Entities\MyCanvas;
use App\Entities\Template;
use CodeIgniter\Model;

class MyCanvasModel extends Model
{
    protected $table = 'tb_cvs_mycvs';
    protected $primaryKey = 'my_canvas_id';
    protected $returnType = MyCanvas::class;
    protected $allowedFields = [
        'user_id','title','thumb_file','blob_data','page','share_flag','rotate','reg_date','reg_ip','reg_id','mod_date','mod_ip','mod_id'
    ];
    protected $validationRules = [
            'user_id'       => 'required'
        ,   'title'         => 'required'
        ,   'reg_date'      => 'required'
        ,   'reg_ip'        => 'required'
        ,   'reg_id'        => 'required'
    ];

    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;

    public function getMyTemplateList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
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
                $whereQueryString .= " AND ( title LIKE :search_text_like: ) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
            } if(empty($arrayParams['search_type']) == false) {
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }

        }

        if(isset($arrayParams['user_id'])) {
            $whereQueryString .= " AND user_id = :user_id: ";
            $aBindParams['user_id'] = $arrayParams['user_id'];
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
                    FROM {$this->table}
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

    public function getMyTemplateInfo(array $arrayParams) : array
    {

        $whereQueryString  = "";
        $aBindParams = [];
        if(isset($arrayParams[$this->primaryKey])) {
            $whereQueryString .= " AND {$this->primaryKey} = :{$this->primaryKey}: ";
            $aBindParams[$this->primaryKey] = $arrayParams[$this->primaryKey];
        }

        if(isset($arrayParams['user_id'])){
            $whereQueryString .= "AND user_id AND user_id = :user_id: ";
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

