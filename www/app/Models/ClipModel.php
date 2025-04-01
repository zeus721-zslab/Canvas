<?php namespace App\Models;

use App\Entities\Clip;
use CodeIgniter\Model;

class ClipModel extends Model
{
    protected $table = 'tb_clip';
    protected $primaryKey = 'clip_id';
    protected $returnType = Clip::class;
    protected $allowedFields = [
        'title', 'keyword', 'category', 'file_mime', 'thumb_file', 'save_file', 'svg_file', 'org_file', 'file_size', 'hit', 'use_flag', 'reg_date', 'reg_ip', 'reg_id', 'mod_date', 'mod_ip', 'mod_id'
    ];
    protected $validationRules = [
          'title'       => 'required'
        , 'category'    => 'required|in_list[clip,bg,topper]'
        , 'use_flag'    => 'required|in_list[Y,N]'
        , 'reg_date'    => 'required'
        , 'reg_ip'      => 'required'
        , 'reg_id'      => 'required'
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;


    public function getClipList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
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
                $whereQueryString .= " AND ( title LIKE :search_text_like: OR FIND_IN_SET(:search_text:, keyword) OR {$this->primaryKey} = :search_text: ) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }else if($arrayParams['search_type'] == 'keyword') {
                $whereQueryString .= " AND FIND_IN_SET(:search_text:, keyword) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
            }else if(empty($arrayParams['search_type']) == false) {
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }
        }

        if(empty($arrayParams['category']) == false) {
            $whereQueryString .= " AND category = :category: ";
            $aBindParams['category'] = $arrayParams['category'];
        }
        if(empty($arrayParams['use_flag']) == false) {
            $whereQueryString .= " AND use_flag = :use_flag: ";
            $aBindParams['use_flag'] = $arrayParams['use_flag'];
        }
        if(empty($arrayParams['s_date']) == false) {
            $whereQueryString .= " AND reg_date >= :s_date: ";
            $aBindParams['s_date'] = $arrayParams['s_date'];
        }
        if(empty($arrayParams['e_date']) == false) {
            $whereQueryString .= " AND reg_date <= :e_date: ";
            $aBindParams['e_date'] = $arrayParams['e_date'];
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

    public function getClipInfo(array $arrayParams) : array
    {

        $whereQueryString  = "";
        $aBindParams = [];
        if(isset($arrayParams['clip_id'])) {
            $whereQueryString .= " AND {$this->primaryKey} = :clip_id: ";
            $aBindParams['clip_id'] = $arrayParams['clip_id'];
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

