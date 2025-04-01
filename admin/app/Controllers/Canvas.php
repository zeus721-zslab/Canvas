<?php
namespace App\Controllers;

use App\Entities\MyImg;
use App\Libraries\CustomImageLib;
use App\Libraries\CustomUploadsLib;
use App\Models\CanvasModel_v2;
use App\Models\ClipModel;
use App\Models\MyImageModel;
use App\Models\TemplateModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Canvas extends BaseController
{

    public $page = 0;
    public $per_page = 30;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger); // TODO: Change the autogenerated stub
    }

    public function index() : string
    {

        $user = auth()->getUser();

        $aData = [
                'nCanvasWidth' => 2200
            ,   'nCanvasHeight' => 1556
            ,   'zoom' => 0.7
            ,   'emRotate' => 'L'
            ,   'aInput' => [
                    'type'          => ''
                ,   'template_id'   => ''
                ,   'user_id'       => $user->id
            ]
            ,   'per_page'  => $this->per_page
        ];

        if(isset($_GET["e"])){
            // YmdHis_new_nIdx_nLoadIdx
            $encrypter          = \Config\Services::encrypter();
            $eEnc               = $this->request->getGet('e');
            $strEnc             = $encrypter->decrypt($eEnc);
            $aEnc               = explode("_",$strEnc);
            $aData['aInput']["type"]            = $aEnc[1];
            $aData['aInput']["template_id"]     = $aEnc[3];

            $canvas_model   = new CanvasModel_v2();
            $aData['aInfo'] = $canvas_model->getTemplateInfo(['template_id' => $aData['aInput']["template_id"]]); // 템플릿클릭 - 템플릿불러오기

            $aData['emRotate'] = $aData['aInfo']['rotate'];

        }else{ //필수입력정보 누락 ERROR
            alert_script('필수입력정보가 없습니다. Params : $_GET["e"]');
            echo '<script>window.close();</script>';
            return false;
        }

        if($aData['emRotate'] == 'P'){
            $aData['nCanvasWidth'] = 1556;
            $aData['nCanvasHeight'] = 2200;
            $aData['zoom'] = 0.6;
        }else if($aData['emRotate'] == 'S'){
            $aData['nCanvasWidth'] = 2200;
            $aData['nCanvasHeight'] = 2200;
        }

        return view('canvas/index' , $aData);

    }

    public function slide() : string
    {
        $aSlideData = json_decode($this->request->getPostGet('aSlideData'),true);
        return view('canvas/slide' , ['aSlideData' => $aSlideData]);
    }

    public function pngtojpgAction($img_data)
    {
        //초기화
        ob_clean();
        flush();

        //Code to convert png to jpg image
        $input = imagecreatefrompng($img_data);
        $width = imagesx($input);
        $height = imagesy($input);
        $output = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($output, 255, 255, 255);
        imagefilledrectangle($output, 0, 0, $width, $height, $white);
        imagecopy($output, $input, 0, 0, 0, 0, $width, $height);

        imagejpeg($output);
        $contents = ob_get_contents();
        //Converting Image DPI to 300DPI
        $contents = substr_replace($contents, pack("cnn", 1, 300, 300), 13, 5);


        return base64_encode($contents);
        //return 'data:image/jpeg;base64,'.base64_encode($contents);

    }

    public function download()
    {

        ini_set('memory_limit', '-1');

        try{

            $user           = auth()->getUser();
            $user_id        = $user->id;
            $sFilePrefix    = sprintf("%s_%04d",date('YmdHis'),rand(0,9999));
            $tempDir        = WRITEPATH.'tmp/'.$user_id.'_'.rand(0,9999);
            $ret            = @mkdir($tempDir);

            if(!$ret){
                log_message('error' , 'Canvas::download Create folder ERROR');
                throw new \Exception('임시 폴더를 생성 중 문제가 발생하였습니다.');
            }

            $err            = false;
            $aImgData       = json_decode($_POST["aImgData"] , true);


            foreach($aImgData as $sIdx => $sImgData){
                $img = $this->pngtojpgAction($sImgData);
//                $img = str_replace('data:image/png;base64,', '', $sImgData);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = sprintf("%s/page_%02d.jpg",$tempDir,$sIdx);
                $success = file_put_contents($file, $data);
                if($success == false) $err = true;
            }

            if($err){
                log_message('error' , 'Canvas::download Create Images ERROR');
                throw new \Exception('이미지 파일을 생성 중 문제가 발생하였습니다.');
            }

            $sCmd = sprintf("cd %s && /usr/bin/zip -r %s.zip * ",$tempDir,$sFilePrefix );
            shell_exec($sCmd); //압축 실행

            $fileFullPath = $tempDir.'/'.$sFilePrefix.'.zip'; //압축파일 전체경로
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($fileFullPath));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileFullPath));
            ob_clean();
            flush();

            if (readfile($fileFullPath))
            {
                helper('filesystem');
                delete_files($tempDir);//파일삭제
                @rmdir($tempDir);//폴더 삭제
            }

            return true;

        } catch(\Exception $e) {

            top_alert_script($e->getMessage());
            return false;

        }

    }

    public function getSearchContents() : string
    {

        $aInput = [
                'type'          => $this->request->getPost('m')
            ,   'search_text'   => $this->request->getPost('str')
        ];

        $clip_model     = new ClipModel();
        $template_model = new TemplateModel();

        if($aInput['type'] == '_clip'){ //요소

            $aSearch["category"]    = 'clip';
            $aSearch["search_text"] = $aInput['search_text'];
            $aList = $clip_model->getClipList($aSearch , false , 0 , $this->per_page);

        }else if($aInput['type'] == '_bg'){ //배경

            $aSearch["category"] = 'bg';
            $aSearch["search_text"] = $aInput['search_text'];
            $aList = $clip_model->getClipList($aSearch, false , 0 , $this->per_page);

        }else if($aInput['type'] == '_template'){ //템플릿 검색

            $aSearch["search_text"] = $aInput['search_text'];
            $aList = $template_model->getTemplateList($aSearch, false , 0 , $this->per_page);

        }

        return json_encode(['success' => true , 'msg' => '' , 'data' => $aList]);

    }


    //--------------------------- ajax call

    public function getContentsWrapPage() : string
    {

        $aInput = [ 'file' => $this->request->getPost('type') ];
        $aSearch = ['view_type' => 'canvas'];

        $canvas_model = new CanvasModel_v2();

        if($aInput['file'] == '_template'){ //템플릿

            $aSearch["search_text"] = $this->request->getPost('strKeyword');
            $aSearch["category"] = 'template';
            $aSearch['view_type'] = 'canvas';
            $aGroup = $canvas_model->getGroupList($aSearch , false , 0 , 20);

            foreach ($aGroup as $k => $r) {
                $aSearch['group_id'] = $r['group_id'];
                $aList = $canvas_model->getTemplateGroupList($aSearch , false , 0 , 5);
                $aGroup[$k]['templates'] = $aList;
            }

            $aInput['aList'] = $aGroup;

        }else if($aInput['file'] == '_text'){ //텍스트

            $aInput['aFontSize'] = [14,16,18,20,22,24,28,36,48,60,72,96,120,144,192,208,240,288];

        }else if($aInput['file'] == '_upload'){ //업로드 파일

            $user = auth()->getUser();
            $aSearch['user_id'] = $user->id;
            $aInput['aMyImg']   = $canvas_model->getMyImgList($aSearch);

        }else if($aInput['file'] == '_clip'){ //요소

            $aSearch["category"] = 'clip';
            $aSearch['view_type'] = 'canvas';
            $aGroup = $canvas_model->getGroupList($aSearch , false , 0 , 20);

            foreach ($aGroup as $k => $r) {
                $aSearch['group_id'] = $r['group_id'];
                $aList = $canvas_model->getClipGroupList($aSearch , false , 0 , 5);
                $aGroup[$k]['clips'] = $aList;
            }

            $aInput['aList'] = $aGroup;

        }else if($aInput['file'] == '_bg'){ //배경

            $aSearch["category"] = 'bg';
            $aSearch['view_type'] = 'canvas';
            $aGroup = $canvas_model->getGroupList($aSearch , false , 0 , 20);

            foreach ($aGroup as $k => $r) {
                $aSearch['group_id'] = $r['group_id'];
                $aList = $canvas_model->getClipGroupList($aSearch , false , 0 , 5);
                $aGroup[$k]['clips'] = $aList;
            }

            $aInput['aList'] = $aGroup;

        }

        return view('canvas/_parts/'.$aInput['file'] , $aInput);
    }

    public function getCvsData() : string
    {

        $canvas_model = new CanvasModel_v2();

        $aInput = [ 'nLoadIdx'  => $this->request->getPost('nLoadIdx') ];

        $aTemplate = $canvas_model->getTemplateInfo(['template_id' => $aInput["nLoadIdx"]]);
        $sOriData = $aTemplate["blob_data"];
        $emRotate = $aTemplate['rotate']??'L';

        $aBlob = '';
        $retBlob = '';
        if($sOriData){
            $aBlob = json_decode($sOriData);
            $retBlob = implode("||",$aBlob);
        }
        $RetVal['success'] = true;
        $RetVal['blob'] = $retBlob;
        $RetVal['emRotate'] = $emRotate;
        $RetVal['csrf'] = csrf_hash();

        return json_encode($RetVal);

    }
    public function getLoadAjax() : bool
    {

        $aInput = [
                'type'  => $this->request->getPost('type')
            ,   'page'  => $this->request->getPost('page')
            ,   'act'   =>  $this->request->getPost('act')
            ,   'search_text' => $this->request->getPost('search_text')
        ];
        $set_page           = $this->request->getPostGet('page') ?? $this->page;
        $set_per_page       = $this->request->getPostGet('per_page') ?? $this->per_page;
        $s_limit            = max(($set_page - 1) * $set_per_page, 0);

//        zsView($set_page);
//        zsView($set_per_page);
//        zsView($s_limit , 1);
        $canvas_model       = new CanvasModel_v2();

        if($aInput['act'] == 'category') {

            if ($aInput['type'] == '_template') { //템플릿

                $aSearch["search_text"] = $this->request->getPost('search_text');
                $aSearch["category"]    = 'template';
                $aSearch['view_type']   = 'canvas';
                $aGroup = $canvas_model->getGroupList($aSearch, false , $s_limit , $set_per_page);

                foreach ($aGroup as $k => $r) {
                    $aSearch['group_id'] = $r['group_id'];
                    $aList = $canvas_model->getTemplateGroupList($aSearch, false , 0 , 5);
                    $aGroup[$k]['templates'] = $aList;
                }

                $aInput['aList'] = $aGroup;

            } else if ($aInput['type'] == '_upload') { //업로드 파일

                $myimg_model = new MyImageModel();
                $user = auth()->getUser();
                $aSearch['user_id'] = $user->id;
                $aInput['aList'] = $myimg_model->getMyImageList($aSearch , false , $s_limit , $set_per_page);

            } else if ($aInput['type'] == '_clip') { //요소

                $aSearch["category"] = 'clip';
                $aSearch['view_type']   = 'canvas';
                $aGroup = $canvas_model->getGroupList($aSearch, false , $s_limit , $set_per_page);

                foreach ($aGroup as $k => $r) {
                    $aSearch['group_id'] = $r['group_id'];
                    $aList = $canvas_model->getClipGroupList($aSearch, false , 0 , 5);
                    $aGroup[$k]['clips'] = $aList;
                }

                $aInput['aList'] = $aGroup;

            } else if ($aInput['type'] == '_bg') { //배경

                $aSearch["category"]    = 'bg';
                $aSearch['view_type']   = 'canvas';
                $aGroup = $canvas_model->getGroupList($aSearch, false , $s_limit , $set_per_page);

                foreach ($aGroup as $k => $r) {
                    $aSearch['group_id'] = $r['group_id'];
                    $aList = $canvas_model->getClipGroupList($aSearch, false, 0, 5);
                    $aGroup[$k]['clips'] = $aList;
                }

                $aInput['aList'] = $aGroup;

            }

        } else if($aInput['act'] == 'search') {

            $clip_model = new ClipModel();
            $template_model = new TemplateModel();

            if($aInput['type'] == '_clip'){ //요소

                $aSearch["category"]    = 'clip';
                $aSearch["search_text"] = $aInput['search_text'];
                $aList = $clip_model->getClipList($aSearch , false , $s_limit , $set_per_page);

            }else if($aInput['type'] == '_bg'){ //배경

                $aSearch["category"] = 'bg';
                $aSearch["search_text"] = $aInput['search_text'];
                $aList = $clip_model->getClipList($aSearch , false , $s_limit , $set_per_page);

            }else if($aInput['type'] == '_template'){ //템플릿 검색

                $aSearch["search_text"] = $aInput['search_text'];
                $aList = $template_model->getTemplateList($aSearch , false , $s_limit , $set_per_page);

            }

            $aInput['aList'] = $aList;

        }else{
            $aInput['aList'] = [];
        }

        echo json_encode(['success' => true , 'msg' => '' , 'data' => $aInput]);

        return true;


    }

    public function userUpload() : bool
    {

        {//validation
            $rules = [ 'upImgFile' => 'uploaded[upImgFile]|mime_in[upImgFile,image/jpeg,image/jpg,image/png,image/gif]' ];
            if (! $this->validate($rules))
            {
                echo json_encode(['success' => false , 'msg' => '' , 'error_msg' => $this->validator->getErrors(), 'csrf' => csrf_hash()]);
                return false;
            }
        }


        { //data set

            $eMyImgEn           = new MyImg(); //entity
            $aInput             = $eMyImgEn->getAttributes(); //set default data
            $user               = auth()->getUser();

            $aInput['user_id']  = $user->id;

        }

        {//file upload

            $oUpload    = new CustomUploadsLib(); //업로드 관련 library

            if($this->request->getFile('upImgFile'))
            {//텍스트 이미지 파일

                $aImg = $oUpload->run(['type' => 'my_img' , 'file_field' => 'upImgFile']);

                if(!$aImg['success']) {
                    echo json_encode(['success' => false , 'msg' => "이미지[upImgFile] 등록 중 문제가 발생했습니다." , 'csrf' => csrf_hash() ]);
                    return false;
                }

                $aInput['image_file']   = $aImg['data']['path'];
                $aImgSize               = getimagesize(DOCROOT.$aImg['data']['path']);
                $aInput['w']            = $aImgSize[0];
                $aInput['h']            = $aImgSize[1];

            }

        }

        $canvas_model   = new CanvasModel_v2();
        $bRet           = $canvas_model->uploadUserImage($aInput);

        $aInput['myimg_id'] = $canvas_model->db->insertID();

        if($bRet) echo json_encode(['success' => true , 'msg' => '' , 'data' => $aInput ]);
        else echo json_encode(['success' => true , 'msg' => '업로드 중 문제가 발생하였습니다.' , 'data' => '' , 'csrf' => csrf_hash() ]);

        return $bRet;
    }

    public function userUploadDelete() : ResponseInterface
    {

        $aInput = [
                'myimg_id'  => $this->request->getPost('myImg_id')
            ,   'user_id'   => auth()->id()
        ];

        $myimg_model = new MyImageModel();
        $aInfo = $myimg_model->getMyImageInfo($aInput);

        $ret = ['success' => false , 'msg' => '삭제가 가능한 업로드파일이 없습니다.'];
        if($aInfo){
            $resp = $myimg_model->delete($aInput['myimg_id']);

            if($resp) $ret = ['success' => true , 'msg' => '업로드 파일을 삭제하였습니다.'];
            else $ret = ['success' => false , 'msg' => '업로드 파일을 삭제하던 중 문제가 발생하였습니다.'];
        }

        return $this->response->setJSON($ret);

    }



}