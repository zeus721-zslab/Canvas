<?php
namespace App\Libraries;

class KCP
{

    public $isTest = false;

    public function __construct()
    {
        /**
         * @TODO : 특정 대상에게만 테스트로 처리되도록 코드 추가
         *
         **/
        if(0){
            $this->isTest = true;
        }

    }

    public function pay_process($aInfo) : array
    {

        /*
        ==========================================================================
             결제 API URL
        --------------------------------------------------------------------------
        */
        $target_URL = $this->isTest ? setting('Payment.target_URL_TEST') : setting('Payment.target_URL');

        /*
        ==========================================================================
             요청정보
        --------------------------------------------------------------------------
        */
        $tran_cd            = $aInfo["tran_cd"]; // 요청코드
        $site_cd            = $aInfo["site_cd"]; // 사이트코드
        // 인증서 정보(직렬화)
        $kcp_cert_info      = $this->isTest ? setting('Payment.cert_key_TEST') : setting('Payment.cert_key');
        $enc_data           = $aInfo["enc_data"]; // 암호화 인증데이터
        $enc_info           = $aInfo["enc_info"]; // 암호화 인증데이터
        /* = -------------------------------------------------------------------------- = */

        $pay_type = 'PACA'; //카드
        if($aInfo["o_paymethod"] == 'vcnt') $pay_type = 'PAVC'; //가상계좌
        else if($aInfo["o_paymethod"] == 'phone') $pay_type = 'PAMC'; //휴대폰

        $data = array(
            "tran_cd"        => $tran_cd,
            "site_cd"        => $site_cd,
            "kcp_cert_info"  => $kcp_cert_info,
            "enc_data"       => $enc_data,
            "enc_info"       => $enc_info,
            "ordr_mony"      => $aInfo['good_mny'], // 실제 결제될 금액이 1004원이라면   ** 결제금액 유효성 검증 **
            "pay_type"       => $pay_type, // 실제 결제할 수단이 신용카드라면 PACA로 세팅 ** 결제수단 유효성 검증 **
            "ordr_no"        => $aInfo['ordr_idxx'], // 실제 처리할 주문번호가 TEST1234567890라면 ** 주문번호검증 **
            /* ordr_no의 경우 결제창으로 전달하는 주문번호와
               실제 승인요청때 처리하는 주문번호가 동일해야하는 경우 검증처리바랍니다.
               다를경우 주문번호 검증은 하지 않으시기 바랍니다. */
        );
        $req_data = json_encode($data);

        $header_data = array( "Content-Type: application/json", "charset=utf-8" );

        // API REQ
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // API RES
        $res_data  = curl_exec($ch);

        // RES JSON DATA Parsing
        return json_decode($res_data, true);

        
    }

}