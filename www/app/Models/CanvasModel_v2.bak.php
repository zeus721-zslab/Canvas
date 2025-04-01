<?php namespace App\Models;

use App\Entities\Canvas;
use CodeIgniter\Model;

class CanvasModel_v2 extends Model
{
    protected $table = 'tb_cvs_template';
    protected $primaryKey = 'template_id';
    protected $returnType = Canvas::class;
    protected $allowedFields = [
        'title','keyword','thumb_file','blob_data','use_flag','hit','page','rotate','reg_date','reg_ip','reg_id','mod_date','mod_ip','mod_id'
    ];
    protected $validationRules = [
          'title'       => 'required'
        , 'thumb_file'  => 'required'
        , 'use_flag'    => 'required|in_list[Y,N]'
        , 'hit'         => 'numeric'
        , 'page'        => 'numeric'
        , 'rotate'      => 'required'
        , 'reg_date'    => 'required'
        , 'reg_ip'      => 'required'
        , 'reg_id'      => 'required'
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;


    public function getTemplateList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams        = [];
        $whereQueryString   = " AND use_flag = 'Y' ";
        $limitQueryString   = "";
        $orderbyQueryString = " ORDER BY {$this->primaryKey} DESC ";

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] =  $s_limit;
            $aBindParams['e_limit'] =  $e_limit;
        }

        if(empty($arrayParams['search_text']) == false){

            if($arrayParams['search_type'] == 'keyword') {
                $whereQueryString .= " AND FIND_IN_SET(:search_text:, keyword) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
            } if(empty($arrayParams['search_type']) == false) {
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            } else {
                $whereQueryString .= " AND ( title LIKE :search_text_like: OR FIND_IN_SET(:search_text:, keyword) OR {$this->primaryKey} = :search_text: ) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }
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

    public function getTemplateInfo(array $arrayParams) : array
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
                WHERE 1 {$whereQueryString};
        ";
        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getRowArray();

        return $aResult ?? [];

    }

    public function getMyData(array $arrayParams) : array
    {

        if( empty($input_my_data['my_canvas_id']) || empty($input_my_data['user_id']) ){
            return [];
        }

        $aBindParams        = [];
        $whereQueryString   = "";

        $whereQueryString .= " AND my_canvas_id = :my_canvas_id: ";
        $aBindParams['my_canvas_id'] = $input_my_data['my_canvas_id'];

        $whereQueryString .= " AND user_id = :user_id: ";
        $aBindParams['user_id'] = $input_my_data['user_id'];

        $sql = "    SELECT
                    * 
                    FROM TblEzCvsList 
                    WHERE 1
                    {$whereQueryString}
        ";
        $aResult = $this->db->query($sql , $aBindParams)->getRowArray();

        return $aResult;

    }

    public function getGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = '';
        $aBindParams = [];
        $limitQueryString = '';

        if(empty($arrayParams["category"]) == false){
            $addWhereQueryString .= " AND category = :category: ";
            $aBindParams['category'] = $arrayParams["category"];
        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] = $s_limit;
            $aBindParams['e_limit'] = $e_limit;
        }

        $sql    = " SELECT 
                    * 
                    FROM tb_group 
                    WHERE use_flag='Y'
                    {$addWhereQueryString}
                    ORDER BY seq ASC
                    {$limitQueryString}
        ";
        $oResult = $this->db->query($sql, $aBindParams);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }

    public function getTemplateGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = '';
        $aBindParams = [];
        $limitQueryString = '';

        if(empty($arrayParams["search_text"]) == false){
            $addWhereQueryString .= " AND ( C.title LIKE :search_text_like: OR FIND_IN_SET(:search_text:, keyword) ) ";
            $aBindParams['search_text_like'] = '%'.$arrayParams["search_text"].'%';
            $aBindParams['search_text'] = $arrayParams["search_text"];
        }

        if(empty($arrayParams["title"]) == false){
            $addWhereQueryString .= " AND C.title = :title: ";
            $aBindParams['title'] = $arrayParams["title"];
        }
        if(empty($arrayParams["keyword"]) == false){
            $addWhereQueryString .= " AND FIND_IN_SET(:keyword:, keyword) ";
            $aBindParams['keyword'] =  $arrayParams['keyword'];
        }

        if(empty($arrayParams["category"]) == false){
            $addWhereQueryString .= " AND A.category = :category: ";
            $aBindParams['category'] = $arrayParams["category"];
        }

        if(empty($arrayParams["group_id"]) == false){
            $addWhereQueryString .= " AND A.group_id = :group_id: ";
            $aBindParams['group_id'] = $arrayParams["group_id"];
        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] = $s_limit;
            $aBindParams['e_limit'] = $e_limit;
        }

        $sql    = " SELECT 
                        A.group_id
                    ,	A.category AS group_category
                    ,	A.title AS group_title
                    ,   C.*
                    FROM tb_group A
                    INNER JOIN tb_template_mapp B on A.group_id = B.group_id
                    INNER JOIN tb_cvs_template C on B.template_id = C.template_id
                    WHERE A.use_flag = 'Y'
                    AND C.use_flag = 'Y'
                    {$addWhereQueryString}
                    ORDER BY A.group_id , A.seq , B.seq
                    {$limitQueryString}
        ";
        $oResult = $this->db->query($sql, $aBindParams);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }

    public function getClipGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = '';
        $aBindParams = [];
        $limitQueryString = '';

        if(empty($arrayParams["search_text"]) == false){
            $addWhereQueryString .= " AND ( C.title LIKE :search_text_like: OR FIND_IN_SET(:search_text:, keyword) ) ";
            $aBindParams['search_text_like'] = '%'.$arrayParams["search_text"].'%';
            $aBindParams['search_text'] = $arrayParams["search_text"];
        }

        if(empty($arrayParams["title"]) == false){
            $addWhereQueryString .= " AND C.title = :title: ";
            $aBindParams['title'] = $arrayParams["title"];
        }
        if(empty($arrayParams["keyword"]) == false){
            $addWhereQueryString .= " AND FIND_IN_SET(:keyword:, keyword) ";
            $aBindParams['keyword'] =  $arrayParams['keyword'];
        }

        if(empty($arrayParams["category"]) == false){
            $addWhereQueryString .= " AND A.category = :category: ";
            $aBindParams['category'] = $arrayParams["category"];
        }

        if(empty($arrayParams["group_id"]) == false){
            $addWhereQueryString .= " AND A.group_id = :group_id: ";
            $aBindParams['group_id'] = $arrayParams["group_id"];
        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] = $s_limit;
            $aBindParams['e_limit'] = $e_limit;
        }

        $sql    = " SELECT 
                        A.group_id
                    ,	A.category AS group_category
                    ,	A.title AS group_title
                    ,   C.*
                    FROM tb_group A
                    INNER JOIN tb_clip_mapp B on A.group_id = B.group_id
                    INNER JOIN tb_clip C on B.clip_id = C.clip_id
                    WHERE A.use_flag = 'Y'
                    AND C.use_flag = 'Y'
                    {$addWhereQueryString}
                    ORDER BY A.group_id , A.seq , B.seq
                    {$limitQueryString}
        ";
        $oResult = $this->db->query($sql, $aBindParams);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }

    public function getMyImgList(array $arrayParams) : array
    {

        $whereQueryString = '';
        $aBindParams = [];
        if(isset($arrayParams['user_id'])) {
            $whereQueryString .= " AND user_id = :user_id: ";
            $aBindParams['user_id'] = $arrayParams['user_id'];
        }

        $sql = "SELECT * 
                FROM tb_cvs_myimg 
                WHERE 1
                {$whereQueryString} 
                ORDER BY myimg_id DESC";

        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }

    public function setData(){





exit;
        $sql = "SELECT * FROM tb_clip";
        $arr = $this->db->query($sql)->getResultArray();

        foreach ($arr as $k => $r) {

            $path = DOCROOT.$r['save_file'];

            $info = getimagesize($path);
            if($info && $info['mime'] != 'application/pdf'){
                $img_w = $info[0];
                $img_h = $info[1];

                zsView("UPDATE tb_clip SET img_w = '{$img_w}' , img_h = '{$img_h}' WHERE clip_id = '{$r['clip_id']}';");
            }else{
                zsView('------------------- '. $r['clip_id'] );
            }

        }


exit;



/*

        $DB = db_connect('cmc');

        $sql = "SELECT * FROM TblClipsGroup";

        $aGroupLists = $DB->query($sql)->getResultArray();

        foreach ($aGroupLists as $k => $r) {

            $datas[] = $r['vcClipsId'];
        }

        $datass = implode(',', $datas);

        $sql = "SELECT * FROM TblClipsMst WHERE nIdx IN ({$datass});";
        $aResult  = $DB->query($sql)->getResultArray();

        //echo count($aResult);


        $f_arr = [];
        foreach ($aResult[0] as $k => $v) {
            $f_arr[] = "`{$k}`";
        }
        $field = 'INSERT INTO TblClipsMst ('.implode(',',$f_arr).') VALUES';

        echo $field;


        $v_arr1 = [];
        foreach ($aResult as $r) {
            $v_arr2 = [];
            foreach ($r as $vv) {
                $v_arr2[] = "'{$vv}'";
            }
            $v_arr1[] = '<br>('.implode(',',$v_arr2).')';

        }

        $data = implode(',',$v_arr1);

        echo $data;
        exit;
*/

//        zsView('INSERT INTO `tb_clip_mapping` (group_id , clip_id , seq , reg_date) VALUES ');
//
//        $sql = "SELECT * FROM TblClipsGroup";
//        $data = $this->db->query($sql)->getResultArray();
//
//        foreach ($data as $k => $r) {
//
//
//            $datas = explode(',',$r['vcClipsId']);
//
//            $jj = 1;
//            foreach ($datas as $kk => $vv) {
//
//                //$sql = "SELECT nidx FROM TblClipsMst WHERE nIdx = :vv: ;";
//                $sql = "SELECT clip_id FROM tb_clip WHERE old_pk = :vv: ;";
//                $id =  $this->db->query($sql, ['vv' => $vv])->getRowArray();
//
//                if($id){
//                    if($jj == 1){
//                        zsView("('{$r['nIdx']}' , '{$id['clip_id']}' , '{$jj}' , date_format(now() , '%Y%m%d%H%i%s'))");
//                    }else{
//                        zsView(",('{$r['nIdx']}' , '{$id['clip_id']}' , '{$jj}' , date_format(now() , '%Y%m%d%H%i%s'))");
//                    }
//                }else{
//                    if(!in_array($vv , [52470,50338,52476,49682,49542,54188])) zsView("ERROR --- nidx = {$r['nIdx']} || old_pk = '{$vv}'");
//                }
//
//                $jj++;
//            }
//
//        }





    }


}

