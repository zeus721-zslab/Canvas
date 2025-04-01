<?php
namespace App\Controllers;

use App\Entities\BoardEn;
use App\Libraries\CustomUploadsLib;
use App\Models\BoardModel;
use App\Models\FileModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BoardManagement extends BaseController
{
    public $pager;
    public $page        = 1; //페이지
    public $per_page    = 30; //페이지당 노출row
    public $boardModel;
    public $prev_dir;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger); // TODO: Change the autogenerated stub
        $this->pager = \Config\Services::pager();
        $this->boardModel = new BoardModel();
        $this->prev_dir = 'notice/'.date('Ymd').'/';
    }

    public function index()
    {
        $aInput     = [];
        $nList      = self::getListTot($aInput);
        $tot_page   = ceil( $nList / $this->per_page );

        $view_data = [
                'tot_page'  => $tot_page
            ,   'per_page'  => $this->per_page
            ,   'uniqId'    => $this->request->getPostGet('id')
        ];

        $this->_header();
        echo view('board/list', $view_data);
        $this->_footer();

    }
    public function upsertForm()
    {

        helper('number');
        
        $aInput       = [ 'board_id'   => $this->request->getPostGet('board_id') ];
        $title        = '공지 등록';

        $enBoard   = New BoardEn();
        $aBoardInfo = $enBoard->getAttributes();
        $aFileInfo       = [];
        
        if(empty($aInput['board_id']) == false){ //update

            $boardModel = new BoardModel();
            $fileModel  = new FileModel();
            $aFileInfo     = $fileModel->getFileInfo(['parent_id' => $aInput['board_id'] , 'loc' => 'notice']);
            $aBoardInfo = $boardModel->asArray()->find($aInput['board_id']);
            $title      = '공지 수정';
        }

        echo view('board/upsert_form', [ 'data' => $aBoardInfo , 'title' => $title , 'aFileInfo' => $aFileInfo ] );

    }

    public function upsert() : ResponseInterface
    {

        isAjaxCheck();

        //validation
        $rules          = [
                'title'     => 'required'
            ,   'content'   => 'required'
        ];
        $isUpdate       = false; //insert | update
        $upsertTitle    = '공지등록';

        if( $this->request->getPostGet('id') ){
            $rules['id']  = 'numeric';
            $isUpdate           = true;
            $upsertTitle        = '공지수정';
        }

        if (! $this->validate($rules))
        {
            return $this->response->setJSON(['success' => false , 'msg' => '' , 'error_msg' => $this->validator->getErrors()]);
        }

//        $user = auth()->getUser();

        if($isUpdate == true){ //update

            $aInput['board_id'] = $this->request->getPostGet('id');
            $aBoardInfo         = $this->boardModel->find($aInput['board_id']);

            if(empty($aBoardInfo) == true){
                return $this->response->setJSON(['success' => false , 'msg' => "정상적인 정보가 아닙니다.\n잠시 후 다시 진행해주세요."]);
            }
            $aInput['mod_date'] = date('YmdHis');
            $aInput['mod_ip'] = $this->request->getIPAddress();
//            $aInput['mod_id']   = $user->id;

        }else{//insert

            $aInput['reg_date'] = date('YmdHis');
            $aInput['reg_ip'] = $this->request->getIPAddress();
//            $aInput['reg_id']   = $user->id;

        }

        $aInput['title']    = $this->request->getPostGet('title');
        $aInput['content']  = $this->request->getPostGet('content');
        $aInput['type']     = 'N';


        $boardEn           = New Boarden($aInput);

        if($isUpdate == true) {
            $ret_id = $this->boardModel->save($boardEn); //수정
            $parent_id = $aInput['board_id'];
        }
        else {
            $ret_id = $this->boardModel->insert($boardEn); //등록
            $parent_id = $this->boardModel->insertID();
        }


        if($this->request->getFile('uploadFile')) //ckeditor
        {//텍스트 이미지 파일
            $oUpload    = new CustomUploadsLib(); //업로드 관련 library
            $aImg = $oUpload->run(['type' => 'notice' , 'file_field' => 'uploadFile']);
            if(!$aImg['success']) {
                $ret = ['success' => false, 'msg' => "{$upsertTitle} 실패.\n잠시 후 다시 시도해주세요.\nErrorMsg : 파일 업로드 중 문제가 발생했습니다." ];
                return $this->response->setJSON($ret);
            }

            $db      = \Config\Database::connect();
            $builder = $db->table('tb_files');

            if($isUpdate == true) {
                $oFileInfo = $builder->getWhere(['parent_id' => $parent_id , 'loc' => 'notice' ,'del_yn' => 'N'])->getRow();
                $oFileInfo->del_yn = 'Y';
                $oFileInfo->del_date = date('YmdHis');
                $oFileInfo->del_id = auth()->id();
                $builder->upsert($oFileInfo); //기존 첨부파일 삭제 flag

                //@TODO 실제 파일 삭제 처리

            }

            $aFile = [
                    'parent_id'     => $parent_id
                ,   'f_path'        => $aImg['data']['path']
                ,   'o_f_name'      => $aImg['data']['originalname']
                ,   'f_name'        => $aImg['data']['filename']
                ,   'f_mime_type'   => $aImg['data']['mimetype']
                ,   'f_size'        => $aImg['data']['size']
                ,   'loc'           => 'notice'
                ,   'reg_date'      => date('YmdHis')
                ,   'reg_id'        => auth()->id()
            ];

            $ret     = $builder->insert($aFile);

            if(!$ret) {
                $ret = ['success' => false, 'msg' => "{$upsertTitle} 실패.\n잠시 후 다시 시도해주세요.\nErrorMsg : 업로드 파일 DB저장 중 문제가 발생했습니다." ];
                return $this->response->setJSON($ret);
            }
        }

        if(empty($ret_id) == true) {
            $ret = ['success' => false, 'msg' => "{$upsertTitle} 실패.\n잠시 후 다시 시도해주세요.\nErrorMsg : ".json_encode($this->boardModel->errors(),JSON_UNESCAPED_UNICODE) , 'error_msg' => $this->boardModel->errors() ];
        }
        else $ret = ['success' => true , 'msg' => "정상적으로 {$upsertTitle}이 완료되었습니다." , 'error_msg' => []];

        return $this->response->setJSON($ret);

    }

    public function delete($type) : ResponseInterface
    {

        isAjaxCheck();

        $boardModel = new BoardModel();
        $fileModel = new FileModel();

        try {

            if($type == 'file'){ // 파일 삭제

                $file_id    = $this->request->getPost('file_id');
                $oFileInfo  = $fileModel->find($file_id);

                if(empty($oFileInfo)){
                    throw new \Exception('삭제할 파일정보가 없습니다.');
                }

                $oFileInfo->del_yn = 'Y';
                $oFileInfo->del_date = date('YmdHis');
                $oFileInfo->del_id = auth()->id();

                $fileModel->save($oFileInfo); //파일삭제 flag

            }else if($type == 'board'){ //공지사항 삭제

                $aBoardId    = $this->request->getPostGet('board_id_arr');

                if(empty($aBoardId) == true){
                    throw new \Exception("삭제할 데이터를 선택해주세요!");
                }

                if(is_array($aBoardId) == false){
                    throw new \Exception(lang('Security.disallowedAction'));
                }

                $aFileList = $fileModel->getFileList(['board_id_arr' => $aBoardId , 'loc' => 'notice']);

                if(empty($aFileList) == false){

                    foreach ($aFileList as $r) {
    //                    $prev_uri  = DOCROOT.'/'.$r['f_path'];
    //                    if(file_exists($prev_uri)) $ret = del_file($prev_uri); // @TODO 권한문제로 삭제 불가 -- 추후 처리

                        $oFileInfo  = $fileModel->find($r['file_id']);
                        $oFileInfo->del_yn = 'Y';
                        $oFileInfo->del_date = date('YmdHis');
                        $oFileInfo->del_id = auth()->id();

                        $fileModel->save($oFileInfo); //파일삭제 flag

                    }
                }

                $aInput = [
                        'board_id'  => $aBoardId
                    ,   'del_date'  => date('YmdHis')
                    ,   'del_id'    => auth()->id()
                ];

                $bRet = $boardModel->del($aInput);

                if(!$bRet) throw new \Exception('삭제도중 문제가 발생하였습니다.');

            }

        } catch(\Exception $e) {
            return $this->response->setJSON(['success' => false , 'msg' => $e->getMessage()]);
        }

        return $this->response->setJSON(['success' => true , 'msg' => '삭제가 완료되었습니다.']);

    }

    public function lists_ajax()
    {
        isAjaxCheck();
        $boardModel = new BoardModel();
        $aInput = [
                'search_text'   => $this->request->getPostGet('search_text')
            ,   'search_type'   => $this->request->getPostGet('search_type')
            ,   'top_fix'       => $this->request->getPostGet('top_fix')
        ];

        $set_page           = $this->request->getPostGet('page') ?? $this->page;
        $set_per_page       = $this->request->getPostGet('per_page') ?? $this->per_page;

        $nBoardList         = self::getListTot($aInput);
        $pagination_html    = $this->pager->makeLinks($set_page,$set_per_page,$nBoardList);
        $tot_page           = $nBoardList / $set_per_page;
        $tot_page           = $tot_page ?? 1;
        $s_limit            = ($set_page - 1) * $set_per_page >= 0 ? ($set_page - 1) * $set_per_page : 0 ;

        $aBoardList         = $boardModel->getBoardList($aInput , false , $s_limit , $set_per_page );

        foreach ($aBoardList as $k => $r) {
            $aBoardList[$k]['VNO'] = $nBoardList - ( ($set_page - 1) * $set_per_page ) - $k;
        }

        $view_data = [
                'data'              => $aBoardList
            ,   'pagination_html'   => $pagination_html
            ,   'tot_page'          => $tot_page
            ,   'tot_cnt'           => $nBoardList
            ,   'per_page'          => $set_per_page
        ];

        echo view('board/list_ajax', $view_data);

    }

    private function getListTot($aInput) : int
    {
        $nBoardList         = $this->boardModel->getBoardList($aInput,true);
        return (int)$nBoardList['cnt'];
    }

}
