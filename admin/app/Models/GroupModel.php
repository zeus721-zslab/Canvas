<?php namespace App\Models;

use App\Entities\Group;
use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table = 'tb_group';
    protected $primaryKey = 'group_id';
    protected $returnType = Group::class;
    protected $allowedFields = [
        'view_type','menu_type','category','title','show_YM','use_flag','seq','reg_date','reg_ip','reg_id','mod_date','mod_ip','mod_id'
    ];
    protected $validationRules = [
            'view_type' => 'required|in_list[canvas,menu,recommend]'
        ,   'category'  => 'required'
        //,   'menu_type' => 'in_list[event,play,env,notice,month]'
        ,   'title'     => 'required'
        ,   'use_flag'  => 'required|in_list[Y,N]'
//        ,   'reg_date'  => 'required'
//        ,   'reg_ip'    => 'required'
//        ,   'reg_id'    => 'required'
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;


    public function getGroupList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
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

        if(isset($arrayParams['orderby'])){
            $orderbyQueryString = " ORDER BY {$arrayParams['orderby']} ";
        }

        if(empty($arrayParams['search_text']) == false){

            if(empty($arrayParams['search_type']) == false) {
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            } else {
                $whereQueryString .= " AND ( C.title LIKE :search_text_like: OR {$this->primaryKey} = :search_text: ) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }
        }

        if(empty($arrayParams['category']) == false){
            $whereQueryString .= " AND C.category LIKE :category: ";
            $aBindParams['category'] =  $arrayParams['category'];
        }

        if(empty($arrayParams['view_type']) == false){

            if(is_array($arrayParams['view_type'])){
                $whereQueryString .= " AND C.view_type IN :view_type: ";
                $aBindParams['view_type'] =  $arrayParams['view_type'];
            }else{
                $whereQueryString .= " AND C.view_type LIKE :view_type: ";
                $aBindParams['view_type'] =  $arrayParams['view_type'];
            }


        }

        if(empty($arrayParams['menu_type']) == false){
            $whereQueryString .= " AND C.menu_type LIKE :menu_type: ";
            $aBindParams['menu_type'] =  $arrayParams['menu_type'];
        }


        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt
                    FROM {$this->table} C
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                    *
                    , CASE  WHEN category IN ('clip' , 'bg') THEN ( SELECT COUNT(*) FROM tb_clip_mapp A INNER JOIN tb_clip B ON A.clip_id = B.clip_id WHERE A.group_id = C.group_id AND B.use_flag = 'Y' )
                            ELSE ( SELECT COUNT(*) FROM tb_template_mapp A INNER JOIN tb_cvs_template B ON A.template_id = B.template_id WHERE A.group_id = C.group_id AND B.use_flag = 'Y' )
                            END AS able_cnt
                    , CASE  WHEN category IN ('clip' , 'bg') THEN ( SELECT COUNT(*) FROM tb_clip_mapp A INNER JOIN tb_clip B ON A.clip_id = B.clip_id WHERE A.group_id = C.group_id AND B.use_flag IN ('N','I') )
                            ELSE ( SELECT COUNT(*) FROM tb_template_mapp A INNER JOIN tb_cvs_template B ON A.template_id = B.template_id WHERE A.group_id = C.group_id AND B.use_flag IN ('N','I') )
                            END AS unable_cnt
                    FROM {$this->table} C
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

    public function getGroupInfo(array $arrayParams) : array
    {

        $whereQueryString  = "";
        $aBindParams = [];
        if(isset($arrayParams[$this->primaryKey])) {
            $whereQueryString .= " AND {$this->primaryKey} = :{$this->primaryKey}: ";
            $aBindParams[$this->primaryKey] = $arrayParams[$this->primaryKey];
        }

        if(!empty($arrayParams['menu_type'])) {
            $whereQueryString .= " AND menu_type = :menu_type: ";
            $aBindParams['menu_type'] = $arrayParams['menu_type'];
        }

        if(!empty($arrayParams['show_YM'])) {
            $whereQueryString .= " AND show_YM = :show_YM: ";
            $aBindParams['show_YM'] = $arrayParams['show_YM'];
        }

        if(!empty($arrayParams['use_flag'])) {
            $whereQueryString .= " AND use_flag = :use_flag: ";
            $aBindParams['use_flag'] = $arrayParams['use_flag'];
        }

        if(!empty($arrayParams['show_YM'])) {
            $whereQueryString .= " AND view_type = :view_type: ";
            $aBindParams['view_type'] = $arrayParams['view_type'];
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

    public function getClipGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = '';
        $aBindParams = [];
        $limitQueryString = '';

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
                    ,	B.seq
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

    public function getTemplateGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = '';
        $aBindParams = [];
        $limitQueryString = '';

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
                    ,	B.seq
                    ,   C.* 
                    FROM tb_group A
                    INNER JOIN tb_template_mapp B on A.group_id = B.group_id
                    INNER JOIN tb_cvs_template C on B.template_id = C.template_id
                    WHERE A.use_flag = 'Y'
                    AND C.use_flag = 'Y'
                    {$addWhereQueryString}
                    ORDER BY A.seq ASC , B.seq ASC
                    {$limitQueryString}
        ";

        $oResult = $this->db->query($sql, $aBindParams);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }


    public function getSortDataOrganize($arrayParams) : array
    {

        $ok_list = [];

        if(count($arrayParams['ok_arr']) > 0) { // ok update / insert 구분

        }


        $no_list = [];

        return [];
    }

    public function getMappDataOrganize($arrayParams) : array
    {

        {//init
            if($arrayParams['category'] == 'template'){
                $mapp_table = 'tb_template_mapp';
                $data_table = 'tb_cvs_template';
                $key_name = 'template_id';
            }else{ // bg / clip
                $mapp_table = 'tb_clip_mapp';
                $data_table = 'tb_clip';
                $key_name = 'clip_id';
            }
        }

        $ok_data = [];
        if(count($arrayParams['ok_arr']) > 0){ // ok update / insert 구분

            $whereQueryString = " AND  A.{$key_name} IN :in_arr: ";
            $aBindParams = [
                    'find_in_set'   => implode(',',$arrayParams['ok_arr'])  // in field
                ,   'group_id'      => $arrayParams['group_id'] // in field
                ,   'in_arr'        => $arrayParams['ok_arr']
            ];
            $sql = "SELECT  FIND_IN_SET(A.{$key_name} , :find_in_set:) AS sort
                        ,   A.{$key_name}
                        ,   (SELECT B.mapp_id FROM {$mapp_table} B WHERE B.{$key_name} = A.{$key_name} AND B.group_id = :group_id: ) AS mapp_id
                    FROM {$data_table} A
                    WHERE 1
                    {$whereQueryString}
                    ORDER BY sort;
            ";
            $ok_data = $this->db->query($sql , $aBindParams)->getResultArray();


        }

        $no_data = [];
        if(count($arrayParams['no_arr']) > 0){ //no

            $whereQueryString = " AND  A.{$key_name} IN :in_arr: ";
            $aBindParams = [
                    'find_in_set'   => implode(',',$arrayParams['no_arr'])  // in $sql
                ,   'group_id'      => $arrayParams['group_id'] // in sql
                ,   'in_arr'        => $arrayParams['no_arr']
            ];
            $sql = "SELECT  FIND_IN_SET(A.{$key_name} , :find_in_set:) AS sort
                        ,   A.{$key_name}
                        ,   (SELECT B.mapp_id FROM {$mapp_table} B WHERE B.{$key_name} = A.{$key_name} AND B.group_id = :group_id: ) AS mapp_id
                    FROM {$data_table} A
                    WHERE 1
                    {$whereQueryString}
                    ORDER BY sort;
            ";
            $no_data = $this->db->query($sql , $aBindParams)->getResultArray();

        }

        { //delete

            $whereQueryString = " AND A.group_id = :group_id: ";
            $aBindParams = ['group_id' => $arrayParams['group_id']];

            if(count($arrayParams['ok_arr']) > 0 && count($arrayParams['no_arr']) > 0){
                $whereQueryString .= " AND {$key_name} NOT IN :tot_arr:";
                $aBindParams['tot_arr'] = array_merge($arrayParams['ok_arr'],$arrayParams['no_arr']);
            }else if(count($arrayParams['no_arr']) > 0) {
                $whereQueryString .= " AND {$key_name} NOT IN :tot_arr:";
                $aBindParams['tot_arr'] = $arrayParams['no_arr'];
            }else if(count($arrayParams['ok_arr']) > 0){
                $whereQueryString .= " AND {$key_name} NOT IN :tot_arr:";
                $aBindParams['tot_arr'] = $arrayParams['ok_arr'];
            }

            $sql = "SELECT B.{$key_name}
                    FROM tb_group A
                    INNER JOIN {$mapp_table} B ON A.group_id = B.group_id
                    WHERE 1
                    {$whereQueryString}
            ";
            $del_data = $this->db->query($sql , $aBindParams)->getResultArray();

        }

        return ['delete' => $del_data , 'ok' => $ok_data , 'no' => $no_data];

    }

    public function insert_mapp($arrayParams) : bool
    {

        if(isset($arrayParams['clip_id'])) {
            $mapp_table = 'tb_clip_mapp';
            $key_value = 'clip_id';
        }
        else {
            $mapp_table = 'tb_template_mapp';
            $key_value = 'template_id';
        }

        $aBindParams['group_id'] = $arrayParams['group_id'];
        $aBindParams[$key_value] = $arrayParams[$key_value];
        $aBindParams['seq'] = $arrayParams['seq'];
        $aBindParams['reg_ip'] = $arrayParams['user_ip'];
        $aBindParams['reg_id'] = $arrayParams['user_id'];

        $sql = "INSERT INTO {$mapp_table}
                SET group_id = :group_id:
                ,   {$key_value} = :{$key_value}:
                ,   seq = :seq:
                ,   reg_date = DATE_FORMAT(NOW() , '%Y%m%d%H%i%s')
                ,   reg_id = :reg_id: 
                ,   reg_ip = :reg_ip: 
        ";

        return $this->db->query($sql , $aBindParams);


//        zsView('------------------- insert mapp');
//        zsView($sql);
//        zsView($aBindParams);

    }

    public function update_mapp($arrayParams , $id) : bool
    {

        unset($arrayParams['group_id']);

        if(isset($arrayParams['clip_id'])) {
            $mapp_table = 'tb_clip_mapp';
            $key_value = 'clip_id';
        }
        else {
            $mapp_table = 'tb_template_mapp';
            $key_value = 'template_id';
        }

        //$aBindParams = $arrayParams;
        $aBindParams[$key_value] = $arrayParams[$key_value];
        $aBindParams['seq'] = $arrayParams['seq'];
        $aBindParams['mod_id'] = $arrayParams['user_id'];
        $aBindParams['mod_ip'] = $arrayParams['user_ip'];
        $aBindParams['mapp_id'] = $id;

        $sql = "UPDATE {$mapp_table}
                SET {$key_value} = :{$key_value}:
                ,   seq = :seq:
                ,   mod_date = DATE_FORMAT(NOW() , '%Y%m%d%H%i%s')
                ,   mod_id = :mod_id: 
                ,   mod_ip = :mod_ip:
                WHERE mapp_id = :mapp_id:
        ";

//        zsView('------------------- update mapp');
//        zsView($sql);
//        zsView($aBindParams);

        return $this->db->query($sql , $aBindParams);

    }

    public function del_mapp($category , $group_id) : bool
    {

        $mapp_table = 'tb_clip_mapp';
        if($category == 'template') $mapp_table = 'tb_template_mapp';

        $sql = "DELETE FROM {$mapp_table} WHERE group_id = :group_id: ;";
        $aBindParams = ['group_id' => $group_id ];

        return $this->db->query($sql , $aBindParams);

    }

    public function setTrans($b = false) :void
    {
        $this->db->transStart($b);
    }
    public function completeTrans() :void
    {
        $this->db->transComplete();
    }
    public function statusTrans() : bool
    {
        return $this->db->transStatus();
    }

}

