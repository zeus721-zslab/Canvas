<?php
namespace App\Controllers;

use App\Entities\Payment;
use App\Entities\User;
use App\Libraries\SMS;
use App\Models\ActionLogModel;
use App\Models\GoodsModel;
use App\Models\PaymentModel;
use App\Models\UserModel;
use App\Models\WehagoModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Psr\Log\LoggerInterface;

class PaymentManagement extends BaseController
{

    public $pager;
    public $page        = 1; //페이지
    public $per_page    = 30; //페이지당 노출row

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger); // TODO: Change the autogenerated stub

        $this->pager = \Config\Services::pager();

    }

    public function index()
    {

        $aInput     = ['search_text' => '' , 'search_type' => ''];
        $nList      = self::getListTot($aInput);
        $tot_page   = ceil( $nList / $this->per_page );

        $view_data = [
                'tot_page'  => $tot_page
            ,   'per_page'  => $this->per_page
            ,   'uniqId'    => $this->request->getPostGet('id')
        ];

        $this->_header();
        echo view('payment/index' , $view_data);
        $this->_footer();

    }

    public function reqCancel()
    {

        $aInput     = ['req_cancel' => 'Y' , 'search_text' => '' , 'search_type' => ''];
        $nList      = self::getListTot($aInput);
        $tot_page   = ceil( $nList / $this->per_page );

        $view_data = [
                'tot_page'  => $tot_page
            ,   'per_page'  => $this->per_page
            ,   'uniqId'    => $this->request->getPostGet('id')
        ];

        $this->_header();
        echo view('payment/reqCancel' , $view_data);
        $this->_footer();

    }

    public function receipt()
    {

        $aInput = [
                'idx'           => $this->request->getGet('oid')
            ,   'receipt_name'  => $this->request->getGet('receipt_name')
        ];

        $payment_model = new PaymentModel();
        $aOrderInfo = $payment_model->asArray()->find($aInput['idx']);
        $aOrderInfo['supply_amount'] = getSupplyAmount($aOrderInfo['amount']);//공급가액
        $aOrderInfo['vat_amount'] = getVatAmount($aOrderInfo['supply_amount']);//부가세액
        $view = \Config\Services::renderer();
        $view->setData(['aOrderInfo' => $aOrderInfo , 'receipt_name' => $aInput['receipt_name'] ]);
        $html = $view->render('payment/receipt');

        try{

            $options = new Options();
            $options->setChroot(DOCROOT . '/fonts');
            $options->setChroot(DOCROOT . '/img');
            $options->setFontDir(DOCROOT . '/fonts');
            $options->setTempDir(DOCROOT . '/fonts');
            $options->setFontCache(DOCROOT . '/fonts');
            $options->set('defaultFont', 'NanumGothic');
            $options->set('isPhpEnabled', true);
            $options->set('isRemoteEnabled',true);

            $dompdf = new Dompdf($options);
            // Load HTML content
            $dompdf->loadHtml($html , mb_detect_encoding($html));
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser
            $dompdf->stream('거래명세서_'.date('YmdHis').'.pdf' );

        } catch (\ErrorException $e){
            top_alert_script("거래명세서를 불러오던 중 문제가 발생하였습니다.\\n[메시지] ".$e->getMessage());
        }


    }

    public function lists_ajax(): string
    {

        isAjaxCheck();

        $aInput = [
                'search_text'   => $this->request->getPostGet('search_text')
            ,   'search_type'   => $this->request->getPostGet('search_type')
            ,   'req_cancel'    => $this->request->getPostGet('req_cancel')
            ,   'isReqCancel'   => $this->request->getPostGet('isReqCancel')
        ];

        if($this->request->getPostGet('pay_flag')) $aInput['pay_flag'] = $this->request->getPostGet('pay_flag');
        if($this->request->getPostGet('o_paymethod')) $aInput['o_paymethod'] = $this->request->getPostGet('o_paymethod');

        $set_page           = $this->request->getPostGet('page') ?? $this->page;
        $set_per_page       = $this->request->getPostGet('per_page') ?? $this->per_page;

        $nPaymentLists      = $this->getListTot($aInput);

        $pagination_html    = $this->pager->makeLinks($set_page,$set_per_page,$nPaymentLists);
        $tot_page           = ceil($nPaymentLists / $set_per_page);
        $tot_page           = $tot_page ?? 1;
        $s_limit            = max(($set_page - 1) * $set_per_page, 0);

        $payment_model      = new PaymentModel();
        $action_log_model   = new ActionLogModel();
        $wehago_model       = new WehagoModel();
        $aPaymentLists      = $payment_model->getPaymentList($aInput, false , $s_limit , $set_per_page);

        foreach ($aPaymentLists as $k => $r) {
            $aPaymentLists[$k]['VNO'] = $nPaymentLists - ( ($set_page - 1) * $set_per_page ) - $k;
            if( $r['cash_receipt'] == 'Y' ){
                $aPaymentLists[$k]['reqTaxSend'] = $wehago_model->asArray()->where(['eTaxType' => 'P' , 'nOrdIdx' => $r['order_id']])->countAllResults();
            }
            //사용로그
            $refInput = [
                    'user_id' => $r['user_id']
                ,   'e_date' => $r['e_use_date']
                ,   's_date' => $r['s_use_date']
            ];
            $action_log = $action_log_model->refOrderCancelData($refInput);
            $isEmpty = true;
            foreach ($action_log as $v) {
                if($v > 0) $isEmpty = false;
            }
            $aPaymentLists[$k]['use_log'] = '';
            if(!$isEmpty) $aPaymentLists[$k]['use_log'] = $action_log;

        }

        $view_data = [
                'data'                  => $aPaymentLists
            ,   'pagination_html'       => $pagination_html
            ,   'tot_page'              => $tot_page
            ,   'tot_cnt'               => $nPaymentLists
            ,   'per_page'              => $set_per_page
        ];

        $view_file = 'payment/lists_ajax';
        if( $aInput['isReqCancel'] == 'Y' ) $view_file = 'payment/req_cancel_ajax';

        return view($view_file , $view_data);

    }

    public function upsertForm(): string
    {

        isAjaxCheck();

        $isUpdate       = false;
        $title          = '결제 등록';
        $ePaymentEn        = new Payment(); //dummy
        $aPaymentInfo      = $ePaymentEn->getAttributes();
        $aPaymentInfo['id'] = '';

        $aInput = ['id' => $this->request->getPostGet('id')];
        if(!empty($this->request->getPostGet('id'))){ //update
            $title          = '결제 정보';
            $payment_model = new PaymentModel();
            $user_model = new UserModel();
            $aPaymentInfo = $payment_model->getPaymentInfo($aInput);
            $aPaymentInfo['user_s_use_date'] = '';
            $aPaymentInfo['user_e_use_date'] = '';
            $aUserInfo = $user_model->asArray()->find($aPaymentInfo['user_id']);

            if($aUserInfo){
                $aPaymentInfo['user_s_use_date'] = $aUserInfo['s_use_date']?view_date_format($aUserInfo['s_use_date'],5):'';
                $aPaymentInfo['user_e_use_date'] = $aUserInfo['e_use_date']?view_date_format($aUserInfo['e_use_date'],5):'';
            }

            $isUpdate = true;
        }

        $view_data = [
                'title'     => $title
            ,   'data'      => $aPaymentInfo
            ,   'isUpdate'  => $isUpdate
        ];

        return view('payment/upsert_form',  $view_data);

    }

    public function cancel_kcp() :ResponseInterface
    {

        return $this->response->setJSON(['success' => false , 'msg' => '준비중입니다']);

        $cPayment = new \Config\Payment();



//{
//"site_cd"         : "T0000",
//"kcp_cert_info"   : "-----BEGIN CERTIFICATE-----MIIDgTCCAmmgAwIBAgI……………
//fWn5Cay7pJNWXCnw4jIiBsTBa3q95RVRyMEcDgPwugMXPXGBwNoMOOpuQ==-----END CERTIFICATE-----",
//"kcp_sign_data"   : "QdwMF6y3GU1JTVkSv7Yn20CCCTeFrKkjvrdZOjShiFibFo...
//cA0nyX+4HEUZ4Fy3U+htmkZqAfJljeujC1KAL5Flnzqbp5Tst5p5SvZ...0qH7NSq0c6BpedDZb04w==",
//"mod_type"        : "STSC",
//"tno"             : "2099123112345"
//}

// site_cd + "^" + tno + "^" + mod_type 규칙으로 생성하며 SHA256withRSA 알고리즘을 통하여 인코딩 후 요청하시기 바랍니다.

//$cancel_target_data = "T0000^22284971100001^STSC";
//// 결제 취소 (cancel) = site_cd^KCP거래번호^취소유형
//
//$key_data = file_get_contents('../splPrikeyPKCS8.pem');
//// 개인키 경로 ("splPrikeyPKCS8.pem" 은 테스트용 개인키)
//$pri_key = openssl_pkey_get_private($key_data,'changeit');
//// 개인키 비밀번호
//
//openssl_sign($cancel_target_data, $signature, $pri_key, 'sha256WithRSAEncryption');
//// 결제 취소 signature 생성
//echo "cancel_signature :".base64_encode($signature)."<br><br>";



        $pri_key_path = APPPATH.'/Kcp/KCP_AUTH_AKGFZ_PRIKEY.pem';

        $aInput = [ 'idx' => $this->request->getPost('idx') ];

        $payment_model = new PaymentModel();

        $oPaymentInfo = $payment_model->where('idx' , $aInput['idx'] )->first();
        $kcp_mod_type = 'STSC'; //전체취소

        $kcp_sign_data = $cPayment->site_code_TEST.'^'.$oPaymentInfo->tno.'^'.$kcp_mod_type;
        $binary_signature = "";


        $key_data = file_get_contents($pri_key_path);
        $pri_key = openssl_pkey_get_private($key_data,'^didvk@215!');

        if ($pri_key === false) {
            zsView(openssl_error_string());
        }else{
            zsView($pri_key);
        }


        $kcp_sign_data_enc = openssl_sign($kcp_sign_data , $binary_signature , $pri_key , 'sha256WithRSAEncryption');

        $req_data = [

                'site_cd'       => $cPayment->site_code_TEST
            ,   'kcp_cert_info' => $cPayment->cert_key_TEST
            ,   'kcp_sign_data' => $kcp_sign_data_enc
            ,   'mod_type'      => $kcp_mod_type
            ,   'tno'           => $oPaymentInfo->tno

        ];

        zsView($req_data,1);


        $header_data = array( "Content-Type: application/json", "charset=utf-8" );

        // API REQ
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $cPayment->cancel_URL_TEST);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        return $this->response->setJSON([]);

    }

    public function ajax_reqCancel() : ResponseInterface
    {


        $aInput = [
                'req_type' => $this->request->getPost('req')
            ,   'order_id' => $this->request->getPost('order_id')
        ];

        try{


            $enPayment = new Payment();
            $payment_model = new PaymentModel();
            $aOrderInfo = $payment_model->asArray()->where(['order_id' => $aInput['order_id']])->first();


            if($aInput['req_type'] == 'C'){ //취소 > 취소 `원복`

                if($aOrderInfo['req_cancel_complete'] == 'Y'){
                    throw new \Exception('이미 취소가 완료된 결제입니다.');
                }

                $aOrderInfo['req_cancel'] = 'N';
                $aOrderInfo['req_cancel_date'] = '';
                $aOrderInfo['mod_date'] = date('YmdHis');
                $aOrderInfo['mod_id'] = auth()->id();
                $aOrderInfo['mod_ip'] = $this->request->getIPAddress();

                $enPayment->fill($aOrderInfo);
                $ret = $payment_model->save($enPayment);

                if(!$ret){
                    throw new \Exception('결제 정보 변경 중 문제가 발생하였습니다.[err_code : 01]');
                }

            }else{ //취소완료


                if($aOrderInfo['req_cancel_complete'] == 'Y'){
                    throw new \Exception('이미 취소가 완료된 결제입니다.');
                }

                $aOrderInfo['pay_flag'] = 'C';
                $aOrderInfo['req_cancel_complete'] = 'Y';
                $aOrderInfo['req_cancel_complete_date'] = date('YmdHis');

                $aOrderInfo['mod_date'] = date('YmdHis');
                $aOrderInfo['mod_id'] = auth()->id();
                $aOrderInfo['mod_ip'] = $this->request->getIPAddress();

                $enPayment->fill($aOrderInfo);
                $ret = $payment_model->save($enPayment);

                if(!$ret){
                    throw new \Exception('결제 정보 변경 중 문제가 발생하였습니다.[err_code : 02]');
                }

            }

            $ret = ['success' => true , 'msg' => '처리가 완료되었습니다.' , 'csrf' => csrf_hash() ];

        }catch (\Exception $e){

            $ret = ['success' => false , 'msg' => $e->getMessage() , 'csrf' => csrf_hash() ];

        }

        return $this->response->setJSON($ret);


    }

    public function upsert() : ResponseInterface
    {

        $payment_model  = new PaymentModel();
        $enPayment      = new Payment();
        {//validation

            //default validation rules
            $rules          = [
                    'id'        => 'required|numeric'
                ,   'pay_flag'  => 'required|in_list[W,Y,C]'
            ];

            $aInfo = $payment_model->getPaymentInfo(['id' => $this->request->getPostGet('id') ]);

            if(empty($aInfo))
            {
                return $this->response->setJSON(['success' => false , 'msg' => "정상적인 정보가 아닙니다.\n새로고침 후 다시 진행해주세요.", 'csrf' => csrf_hash()]);
            }

            if (! $this->validate($rules))
            {
                return $this->response->setJSON(['success' => false , 'msg' => '' , 'error_msg' => $this->validator->getErrors(), 'csrf' => csrf_hash()]);
            }

        }

        try {

            $payment_model->db->transBegin();

            $good_model = new GoodsModel();
            $user_model = new UserModel();
            $enUser     = new User();

            $aGoodInfo = $good_model->asArray()->find($aInfo['good_id']);
            $aUserInfo = $user_model->asArray()->find($aInfo['user_id']);

            { //data set

                $aInput = [
                        'idx'       => $this->request->getPost('id')
                    ,   'pay_flag'  => $this->request->getPost('pay_flag')
                    ,   'memo'      => $this->request->getPost('memo')
                    ,   'deposit_sms_yn' => 'Y'
                    ,   'mod_date'  => date('YmdHis')
                    ,   'mod_id'    => auth()->id()
                    ,   'mod_ip'    => $this->request->getIPAddress()
                ];

                if( $aInfo['pay_flag'] != 'Y' && $aInput['pay_flag'] == 'Y' ){

                    $aInput['pay_date'] = date('YmdHis');

                    if($aUserInfo['e_use_date'] >= date('Ymd')){ //기간연장
                        $aInput['s_use_date'] = $aUserInfo['e_use_date'];
                        $timestamp            = strtotime("+{$aGoodInfo['months']} month", strtotime( $aUserInfo['e_use_date']."000000"));;
                        $aInput['e_use_date'] = date("Ymd", $timestamp);
                    }else{
                        $aInput['s_use_date'] = date('Ymd');
                        $aInput['e_use_date'] = date("Ymd", strtotime("+{$aGoodInfo['months']} month"));
                    }

                }

                if($aInput['pay_flag'] != 'Y') $aInput['pay_date'] = '';

                if( $this->request->getPost('cancel_type') == 'req_cancel' ){//취소 요청에 의한 취소인 경우
                    $aInput['req_cancel_complete'] = 'Y';
                    $aInput['req_cancel_complete_date'] = date('YmdHis');
                }

            }

            {//결제정보 수정
                $enPayment->fill($aInput);
                $ret = $payment_model->save($enPayment);
                if (!$ret) throw new \Exception('결제 정보 수정 중 문제가 발생하였습니다.');
            }

            if($this->request->getPost('send_sms') == 'Y'){//결제 정보 send sms
                $sms      = new SMS();
                $aSmsInfo = [
                    'send_date' => date('YmdHis')
                    ,   'DEST_INFO' => $aInfo['o_name'].'^0'.onlynumber($aInfo['o_celltel'])
                ];

                $aSmsInfo['msg'] = "{$aInfo['o_name']}님. {$aInfo['good_name']} 입금이 완료되었습니다.";//입금완료

                $ret = $sms->sendSMS($aSmsInfo);

                if(empty($ret)){
                    throw new \Exception('입금완료 메시지 발송중 문제가 발생하였습니다.');
                }
            }

            {//회원정보 이용기간 dateset

                if($aInfo['pay_flag'] == 'Y' && $aInput['pay_flag'] != 'Y'){//이전 결제상태가 결제완료 상태 였을 때
                    //회원정보의 이용기간을 줄임
                    $aUserInfo['s_use_date'] = onlynumber($this->request->getPost('s_use_date'));
                    $aUserInfo['e_use_date'] = onlynumber($this->request->getPost('e_use_date'));

                    if($aUserInfo['s_use_date'] >= $aUserInfo['e_use_date']){
                        $aUserInfo['e_use_date'] = '';
                        $aUserInfo['s_use_date'] = '';
                    }

                }

                if($aInfo['pay_flag'] != 'Y' && $aInput['pay_flag'] == 'Y'){//이전 결제상태가 결제전 상태 였을 때
                    //회원정보의 이용기간을 늘림
                    if($aUserInfo['e_use_date'] >= date('Ymd')){ //기간 연장
                        $timestamp = strtotime("+{$aGoodInfo['months']} month", strtotime( $aUserInfo['e_use_date']."000000"));
                        $aUserInfo['e_use_date'] = date("Ymd", $timestamp);
                    }else{//신규
                        $aUserInfo['s_use_date'] = date('Ymd');
                        $aUserInfo['e_use_date'] = date("Ymd", strtotime("+{$aGoodInfo['months']} month"));
                    }
                }
            }

            {//회원정보 이용기간 수정
                $enUser->fill($aUserInfo);
                $user_model->save($enUser);
            }

            if ($payment_model->db->transStatus() === false){

                $payment_model->db->transRollback();
                throw new \Exception('입금처리 프로세스를 진행 중 데이터베이스에 문제가 발생하였습니다.');

            }else{

                $payment_model->db->transCommit();


            }

            $ret = ['success' => true , 'msg' => '결제정보 수정 완료', 'csrf' => csrf_hash()];

        }catch (\Exception $e){
            $ret = ['success' => false , 'msg' => $e->getMessage(), 'csrf' => csrf_hash()];
        }

        return $this->response->setJSON($ret);

    }

    public function chkReqCancelCnt() : ResponseInterface
    {

        $payment_model = new PaymentModel();
        $nCnt = $payment_model->where(['req_cancel' => 'Y' , 'req_cancel_complete' => 'N'])->countAllResults();
        $ret = ['success' => true , 'cnt' => $nCnt, 'csrf' => csrf_hash() ];

        return $this->response->setJSON($ret);

    }

    public function getCancelInfo() : ResponseInterface
    {

        $aInput = [ 'order_id' => $this->request->getPost('order_id') ];

        try {

            if(empty($aInput['order_id'])){
                throw new \Exception('주문아이디가 없습니다.');
            }

            $payment_model  = new PaymentModel();
            $user_model     = new UserModel();
            $aInfo          = $payment_model->asArray()->where(['order_id' => $aInput['order_id']])->first();

            if(empty($aInfo)){
                throw new \Exception('주문정보가 없습니다.');
            }

            $aUserInfo = $user_model->asArray()->find($aInfo['user_id']);

            if(empty($aUserInfo)){
                throw new \Exception('주문자 회원정보가 없습니다.');
            }

            $aInfo['user_s_use_date'] = view_date_format($aUserInfo['s_use_date'],5);
            $aInfo['user_e_use_date'] = view_date_format($aUserInfo['e_use_date'],5);

            $ret = ['success' => true , 'msg' => '','data' => $aInfo, 'csrf' => csrf_hash() ];

        } catch (\Exception $e){
            $ret = ['success' => false , 'msg' => $e->getMessage() ,'data' => [], 'csrf' => csrf_hash() ];
        }

        return $this->response->setJSON($ret);

    }


    private function getListTot($aInput) : int
    {

        $payment_model = new PaymentModel();
        $nLists = $payment_model->getPaymentList($aInput,true);
        $nLists = array_shift($nLists);
        if(empty($nLists)) $nLists = 0;

        return (int)$nLists;

    }

}