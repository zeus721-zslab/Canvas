<?php namespace App\Models;

use App\Entities\BoardEn;
use CodeIgniter\Model;

class BoardModel extends Model
{
    protected $table = 'tb_board';
    protected $primaryKey = 'board_id';
    protected $returnType = BoardEn::class;
    protected $allowedFields = [ 'type' , 'title' , 'content' , 'del_yn' , 'del_date' , 'del_id' , 'reg_date', 'reg_ip' , 'mod_date', 'mod_ip' ];
    protected $validationRules = [
        'type'          => 'required|in_list[N]',
//        'top_fix'       => 'required|in_list[Y,N]',
        'title'         => 'required',
        'content'      => 'required',
//        'del_yn'        => 'required|in_list[Y,N]',
        'reg_date'      => 'required',
        'reg_ip'        => 'required',

    ];
    protected $skipValidation = false;
    protected $validationMessages = [];

    public function getBoardList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams = [];
        $whereQueryString = " AND del_yn = 'N' ";
        $limitQueryString = "";
        $orderbyQueryString = " ORDER BY {$this->primaryKey} DESC ";

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] = $s_limit;
            $aBindParams['e_limit'] = $e_limit;
        }

        if(empty($arrayParams['search_text']) == false){
            if(empty($arrayParams['search_type']) == false) {
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                $aBindParams['search_text_like'] = '%'.$arrayParams['search_text'].'%';
            }
            else {
                $whereQueryString .= " AND ( title LIKE :search_text_like: OR content LIKE :search_text_like: OR {$this->primaryKey} = :search_text: ) ";
                $aBindParams['search_text_like'] = '%'.$arrayParams['search_text'].'%';
                $aBindParams['search_text'] = $arrayParams['search_text'];
            }
        }

        if(empty($arrayParams['top_fix']) == false) {
            $whereQueryString .= " AND top_fix = :top_fix: ";
            $aBindParams['top_fix'] = $arrayParams['top_fix'];
        }
        if(empty($arrayParams['type']) == false) {
            $whereQueryString .= " AND type = :type: ";
            $aBindParams['type'] = $arrayParams['type'];
        }

        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt
                    FROM {$this->table}
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql,$aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                    *
                    , (SELECT COUNT(*) FROM tb_files TF WHERE TF.parent_id = board_id AND TF.loc = 'notice' AND TF.del_yn = 'N') AS file_cnt
                    FROM {$this->table}
                    WHERE 1 
                    {$whereQueryString}
                    {$orderbyQueryString}
                    {$limitQueryString}
            ";
            $oResult = $this->db->query($sql,$aBindParams);
            $aResult = $oResult->getResultArray();
        }

        return $aResult;

    }

    public function getBoardInfo(array $arrayParams) : array
    {

        $whereQueryString  = " AND del_yn = 'N' ";

        if(isset($arrayParams['req_id'])) $whereQueryString .= " AND {$this->primaryKey} = '{$arrayParams['req_id']}' ";

        $sql = "SELECT 
                * 
                FROM {$this->table} 
                WHERE 1 {$whereQueryString}
        ";
        $oResult = $this->db->query($sql);
        $aResult = $oResult->getRowArray();

        return $aResult ?? [];

    }


    /**
     * @date 20210908
     * @modify 황기석
     * @desc 게시판글의 이전글 & 다음글 정보
     */
    public function getAnotherInfo(array $arrayParams) : array
    {

        {//다음글
            $whereQueryString = " AND del_yn = 'N' ";

            if (empty($arrayParams['type']) == false) $whereQueryString .= " AND type = '{$arrayParams['type']}' ";
            if (empty($arrayParams['board_id']) == false) $whereQueryString .= " AND board_id > '{$arrayParams['board_id']}' ";

            $sql = "SELECT 
                * 
                FROM tb_board
                WHERE 1
                {$whereQueryString} 
                ORDER BY board_id ASC
                LIMIT 1;
            ";

            $oResult = $this->db->query($sql);
            $aNext = $oResult->getRow();
        }

        {//이전글
            $whereQueryString = " AND del_yn = 'N' ";

            if (empty($arrayParams['type']) == false) $whereQueryString .= " AND type = '{$arrayParams['type']}' ";
            if (empty($arrayParams['board_id']) == false) $whereQueryString .= " AND board_id < '{$arrayParams['board_id']}' ";

            $sql = "SELECT 
                * 
                FROM tb_board
                WHERE 1
                {$whereQueryString}
                ORDER BY board_id DESC
                LIMIT 1;
            ";

            $oResult = $this->db->query($sql);
            $aPrev = $oResult->getRow();
        }

        return ['aNext' => $aNext , 'aPrev' => $aPrev];

    }

    public function del($arrayParams) : bool
    {

        if(!is_array($arrayParams['board_id'])) {
            $board_id = $arrayParams['board_id'];
            unset($arrayParams['board_id']);
            $arrayParams['board_id'][] = $board_id;
        }

        $aBindParams = $arrayParams;

        $sql = "UPDATE {$this->table}
                SET
                    del_yn = 'Y'
                ,   del_date = :del_date:
                ,   del_id  = :del_id:
                WHERE board_id IN :board_id:
        ";

        return $this->db->query($sql, $aBindParams);

    }


}

