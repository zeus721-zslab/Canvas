<?php

namespace App\Libraries;

use CodeIgniter\View\View as BaseView;
use Config\Services;

class CustomView extends BaseView
{

    public function __construct($config = null)
    {
        // 기본 View 경로 설정
        $viewPath = APPPATH . 'Views/';

        // IP 주소 확인
        $clientIP = service('request')->getIPAddress();
        //$aAllowedIP = ['175.209.219.82']; // 허용된 IP 주소
        $aAllowedIP = []; // 허용된 IP 주소
        if (in_array($clientIP , $aAllowedIP)) {
            $viewPath = APPPATH . 'Skin/ViewTest/'; // 변경된 View 경로
        }

        // 부모 클래스 생성자 호출
        parent::__construct(
            $config,
            $viewPath, // 변경된 View 경로 전달
            Services::locator(), // FileLocator 객체 전달
            CI_DEBUG,
            service('logger')
        );

    }

}