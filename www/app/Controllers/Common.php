<?php
namespace App\Controllers;

use App\Models\BoardModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Common extends BaseController
{

    public $page = 0;
    public $per_page = 30;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger); // TODO: Change the autogenerated stub
    }

    public function termOfUs() : bool
    {

        $this->_header();
        echo view('common/term_of_us');
        $this->_footer();

        return true;

    }

    public function privacy() : bool
    {
        $this->_header();
        echo view('common/privacy');
        $this->_footer();

        return true;
    }

    public function userGuide() : bool
    {
        $this->_header();
        echo view('common/user_guide');
        $this->_footer();

        return true;
    }

    public function notice() : bool
    {
        $aInput     = ['type' => 'N']; //type = N : 공지사항
        $nList      = self::getBoardTot($aInput);
        $tot_page   = ceil( $nList / $this->per_page );

        $view_data = [
                'tot_page'  => $tot_page
            ,   'per_page'  => $this->per_page
        ];

        $this->_header();
        echo view('common/notice' , $view_data);
        $this->_footer();

        return true;
    }
    public function notice_view($board_id)
    {

        $board_model = new BoardModel();
        $aInfo       = $board_model->asArray()->find($board_id);

        if(empty($aInfo)){
            return redirect()->back()->with('errors','공지사항 정보가 없습니다.');
        }

        $aInput = [
                'parent_id' => $aInfo['board_id']
            ,   'loc'       => 'notice'
            ,   'del_yn'    => 'N'
        ];

        {//get fileinfo
            $db = \Config\Database::connect();
            $files_bulider = $db->table('tb_files');
            $aFileInfo = $files_bulider->getWhere($aInput)->getRowArray();
        }

        helper('number');

        $view_data = [
                'aInfo' => $aInfo
            ,   'aFileInfo' => $aFileInfo
        ];

        $this->_header();
        echo view('common/notice_view' , $view_data);
        $this->_footer();

    }
    public function notice_ajax()
    {
        $pager = \Config\Services::pager();

        $aInput = [
                'search_text'   => $this->request->getPostGet('search_text')
            ,   'search_type'   => $this->request->getPostGet('search_type')
            ,   'type'          => 'N' //type = N : 공지사항
        ];

        $set_page           = $this->request->getPostGet('page') ?? $this->page;
        $set_per_page       = $this->request->getPostGet('per_page') ?? $this->per_page;

        $nBoardLists        = $this->getBoardTot($aInput);

        $pagination_html    = $pager->makeLinks($set_page,$set_per_page,$nBoardLists);
        $tot_page           = ceil($nBoardLists / $set_per_page);
        $tot_page           = $tot_page ?? 1;
        $s_limit            = max(($set_page - 1) * $set_per_page, 0);


        $board_model = new BoardModel();
        $aBoardLists = $board_model->getBoardList($aInput, false , $s_limit , $set_per_page);

        foreach ($aBoardLists as $k => $r) {
            $aBoardLists[$k]['VNO'] = $nBoardLists - ( ($set_page - 1) * $set_per_page ) - $k;
        }

        $view_data = [
                'data'                  => $aBoardLists
            ,   'pagination_html'       => $pagination_html
            ,   'tot_page'              => $tot_page
            ,   'tot_cnt'               => $nBoardLists
            ,   'per_page'              => $set_per_page
        ];

        return view('common/notice_ajax' , $view_data);

    }


    private function getBoardTot($aInput) : int
    {

        $board_model = new BoardModel();
        $nLists = $board_model->getBoardList($aInput,true);
        $nLists = array_shift($nLists);
        if(empty($nLists)) $nLists = 0;

        return (int)$nLists;

    }
    //공지사항 첨부파일다운로드
    public function download_file(){

        $file_id = $this->request->getGetPost('file_id');

        if($file_id){

            $db = \Config\Database::connect();
            $files_bulider = $db->table('tb_files');
            $oFileInfo = $files_bulider->getWhere(['file_id'=>$file_id])->getRow();
            $oFileInfo->download_counter = $oFileInfo->download_counter+1;
            $files_bulider->upsert($oFileInfo); //다운로드 count update
            $aInput['org_file_name'] = $oFileInfo->o_f_name;
            $aInput['file_path'] = DOCROOT.$oFileInfo->f_path;
        }else{
            top_alert_script('필수입력사항 누락.');
            exit;
        }

        if(file_exists($aInput['file_path']) == false){
            top_alert_script('첨부파일이 없습니다.');
            exit;
        }


        return $this->response->download($aInput['file_path'], null)->setFileName($aInput['org_file_name']);

    }


    public function save_log() : ResponseInterface
    {

        $aInput = [
                'type' => $this->request->getPost('type')
            ,   'cid' => $this->request->getPost('cid')  ? $this->request->getPost('cid') : 0
            ,   'mid' => $this->request->getPost('mid')  ? $this->request->getPost('mid') : 0
            ,   'tid' => $this->request->getPost('tid')  ? $this->request->getPost('tid') : 0
        ];

        save_log($aInput['type'] , $aInput['tid'] , $aInput['mid'] , $aInput['cid']);

        return $this->response->setJSON(['success' => true , 'msg' => '' , 'csrf' => csrf_hash()]);

    }
    public function myInfo() : ResponseInterface
    {

        $id = auth()->id();
        $user_model = new UserModel();
        $aUserInfo = $user_model->setTable('tb_user')->where('id' , $id)->first();

        if($aUserInfo){
            return $this->response->setJSON(['success' => true , 'msg' => '' , 'data' => $aUserInfo , 'csrf' => csrf_hash()]);
        }else{
            return $this->response->setJSON(['success' => false , 'msg' => '회원정보가 없습니다.' , 'data' => [] , 'csrf' => csrf_hash()]);
        }

    }

}