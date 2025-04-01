<?php namespace App\Models;

use App\Libraries\CustomImageLib;
use CodeIgniter\Model;
use ZipStream\Exception;

class CanvasModel_v2 extends Model
{
    protected $useTimestamps = false;


    public function getTemplateList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams        = [];
        $whereQueryString   = " AND use_flag = 'Y' ";
        $limitQueryString   = "";
        $orderbyQueryString = " ORDER BY template_id DESC ";

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
                $whereQueryString .= " AND ( title LIKE :search_text_like: OR FIND_IN_SET(:search_text:, keyword) OR template_id = :search_text: ) ";
                $aBindParams['search_text'] =  $arrayParams['search_text'];
                $aBindParams['search_text_like'] =  '%'.$arrayParams['search_text'].'%';
            }
        }


        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt
                    FROM tb_cvs_template
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                    *
                    FROM tb_cvs_template
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
        if(isset($arrayParams['template_id'])) {
            $whereQueryString .= " AND template_id = :template_id: ";
            $aBindParams['template_id'] = $arrayParams['template_id'];
        }

        $sql = "SELECT 
                * 
                FROM tb_cvs_template
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


        if(empty($arrayParams["group_id"]) == false){
            $addWhereQueryString .= " AND group_id = :group_id: ";
            $aBindParams['group_id'] = $arrayParams["group_id"];
        }

        if(empty($arrayParams["view_type"]) == false){
            $addWhereQueryString .= " AND view_type = :view_type: ";
            $aBindParams['view_type'] = $arrayParams["view_type"];
        }

        if(empty($arrayParams["category"]) == false){
            $addWhereQueryString .= " AND category = :category: ";
            $aBindParams['category'] = $arrayParams["category"];
        }

        if(empty($arrayParams["menu_type"]) == false){
            $addWhereQueryString .= " AND menu_type = :menu_type: ";
            $aBindParams['menu_type'] = $arrayParams["menu_type"];
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
//        zsView($aBindParams);
//        zsView($sql,1);
        $oResult = $this->db->query($sql, $aBindParams);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }

    public function getTemplateGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = " AND C.use_flag = 'Y' ";
        $aBindParams = [];
        $limitQueryString = '';


        if(isset($arrayParams['isUseFlagAll']) && $arrayParams['isUseFlagAll'] == true){
            $addWhereQueryString = "";
        }

        if(empty($arrayParams["show_YM"]) == false){
            $addWhereQueryString .= " AND A.show_YM = :show_YM: ";
            $aBindParams['show_YM'] = $arrayParams["show_YM"];
        }


        if(empty($arrayParams["menu_type"]) == false){
            $addWhereQueryString .= " AND A.menu_type = :menu_type: ";
            $aBindParams['menu_type'] = $arrayParams["menu_type"];
        }

        if(empty($arrayParams["search_type"]) == false){
            $addWhereQueryString .= " AND A.menu_type = :search_type: ";
            $aBindParams['search_type'] = $arrayParams["search_type"];
        }

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

        if(empty($arrayParams['rotate']) == false){
            $addWhereQueryString .= " AND C.rotate = :rotate: ";
            $aBindParams['rotate'] = $arrayParams['rotate'];
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
                    {$addWhereQueryString}
                    ORDER BY A.seq , B.seq, A.group_id
                    {$limitQueryString}
        ";

        $oResult = $this->db->query($sql, $aBindParams);
        $aResult = $oResult->getResultArray();
        return $aResult;

    }

    public function getClipGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = " AND C.use_flag = 'Y' ";
        $aBindParams = [];
        $limitQueryString = '';


        if(isset($arrayParams['isUseFlagAll']) && $arrayParams['isUseFlagAll'] == true){
            $addWhereQueryString = "";
        }

        if(empty($arrayParams["menu_type"]) == false){
            $addWhereQueryString .= " AND A.menu_type = :menu_type: ";
            $aBindParams['menu_type'] = $arrayParams["menu_type"];
        }

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
                    ,	B.seq
                    ,   C.*
                    FROM tb_group A
                    INNER JOIN tb_clip_mapp B on A.group_id = B.group_id
                    INNER JOIN tb_clip C on B.clip_id = C.clip_id
                    WHERE A.use_flag = 'Y'
                    {$addWhereQueryString}
                    ORDER BY A.seq , B.seq, A.group_id
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

    public function uploadUserImage(array $arrayParams) : bool
    {
        if(!isset($arrayParams['image_file'])) return false;
        $aBindParams = [
                'user_id'   => $arrayParams['user_id']
            ,   'image_file'   => $arrayParams['image_file']
            ,   'w'   => $arrayParams['w']
            ,   'h'   => $arrayParams['h']
        ];

        $sql = "INSERT INTO tb_cvs_myimg
                SET
                    user_id     = :user_id:
                ,   image_file  = :image_file:
                ,   w           = :w:
                ,   h           = :h:
                ,   reg_date    = DATE_FORMAT(NOW(), '%Y%m%d%H%i%s') 
        ";

        return $this->db->query($sql , $aBindParams);

    }

    public function onHit(int $template_id) : bool
    {

        $sql = "UPDATE `tb_cvs_template` SET hit = hit + 1 WHERE template_id = :template_id: ;";
        $aBindParams['template_id'] = $template_id;

        return $this->db->query($sql , $aBindParams);

    }

    public function setData()
    {


        exit;
        $sql = " SELECT * FROM `tb_clip` WHERE thumb_file IS NULL; ";
        $aList = $this->db->query($sql)->getResultArray();

        $oImage = new CustomImageLib();

        zsView('------- start : '.time());
        foreach ($aList as $r) {

            $file_name_tmp = explode('/',$r['save_file']);
            $file_name = $file_name_tmp[count($file_name_tmp) - 1];
            $aImgInput = [
                'act'       => 'create'
                ,   'path'      => $r['save_file']
                ,   'file_name' => $file_name
                ,   'type'      => 'clip'
                ,   'h'         => 150
            ];

            $aResizeImg = $oImage->resize_h($aImgInput);

            if($aResizeImg['success'] == false){
                echo json_encode(['success' => false , 'msg' => "이미지 리사이징 중 문제가 발생했습니다." , 'csrf' => csrf_hash() ]);
                return false;
            }

            $update_sql = "UPDATE tb_clip SET thumb_file = '{$aResizeImg['data']}' WHERE clip_id = '{$r['clip_id']}'; ";

            try {

                $ret = $this->db->query($update_sql);
                if(!$ret){
//                    throw new Exception("update Error : query :: {$update_sql}", 500);
                }

            } catch (\Exception $e){

                zsView($e->getMessage());

            }





        }

        zsView('------- end : '.time());


        exit;
//zsView($r['template_id'] . '///'.$r['title'] . '///'. $r['old_pk']);
//346///아이스크림 캐릭터///366
//380///오리 스티커///400
//383///돌고래///403
//463///개구리 메모지///483
//464///달팽이 메모지///484
//248///생일축하 라벨///267
        //$sql = "SELECT * FROM tb_cvs_template WHERE title NOT LIKE 'tem%' AND template_id not in (346,380,383,463,464,248); ";
        $sql = "SELECT * FROM tb_cvs_template WHERE template_id in (346,380,383,463,464,248); ";
        $aList = $this->db->query($sql)->getResultArray();


        $j = 0;

        zsView(' INSERT INTO tb_clip (title , keyword , category, file_mime , save_file , org_file , file_size , img_w , img_h , hit , use_flag , reg_date , reg_ip , reg_id ) VALUES ');
        $update_str = [];
        foreach ($aList as $k => $r) {
            $decode_data = json_decode($r['blob_data'],true);

//            zsView('------------------------------ '.$r['template_id'] . '///'.$r['title'] . '///'. $r['old_pk']);

            if(empty($decode_data)){
                zsView('err1');
                zsView($r);
                zsView('-------------------------------');
            }else{
                if(count($decode_data) > 1){
                    zsView('err2');
                    zsView($r);
                    zsView($decode_data);
                    zsView('-------------------------------');
                }
            }

            foreach ($decode_data as $vv) {
                $decode_data2 = json_decode($vv,true);

                $xx = 0;

                foreach ($decode_data2['objects'] as $rrr) {
                    if($rrr['type'] == 'image'){

                        $rrr['src'] = str_replace('https://www.edupre.co.kr' , '' , $rrr['src']);
                        $rrr['src'] = str_replace('http://www.edupre.co.kr' , '' , $rrr['src']);

                        $aImg       = getimagesize(DOCROOT.'/'.$rrr['src']);
                        $file_size  = filesize(DOCROOT.'/'.$rrr['src']);

                        $temp_file_arr = explode('/',$rrr['src']);
                        $temp_file_name = $temp_file_arr[count($temp_file_arr)-1];

                        if($k == 0){
                            zsView("('{$r['title']}' , '{$r['keyword']}' , 'clip' ,  '{$aImg['mime']}', '{$rrr['src']}' , '{$temp_file_name}' , '{$file_size}' , '{$aImg[0]}','{$aImg[1]}', 0 , 'Y', DATE_FORMAT(NOW(),'%Y%m%d%H%i%s') , '127.0.0.1' , 1 ) ");
                        }else{
                            zsView(",('{$r['title']}' , '{$r['keyword']}' , 'clip' ,  '{$aImg['mime']}', '{$rrr['src']}' , '{$temp_file_name}' , '{$file_size}' , '{$aImg[0]}','{$aImg[1]}', 0 , 'Y', DATE_FORMAT(NOW(),'%Y%m%d%H%i%s') , '127.0.0.1' , 1 ) ");
                        }


                        $update_str[] = "UPDATE tb_cvs_template SET use_flag = \"N\" WHERE template_id = \"{$r['template_id']}\";  ";



                    }
                }





            }
//            zsView($decode_data);exit;
        }

zsView("총 {$j}건");


        foreach ($update_str as $v) {
            zsView($v);
        }









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

