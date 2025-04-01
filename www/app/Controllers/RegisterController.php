<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Traits\Viewable;
use Psr\Log\LoggerInterface;

/**
 * Class RegisterController
 *
 * Handles displaying registration form,
 * and handling actual registration flow.
 */
class RegisterController extends ShieldRegister
{
    use Viewable;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController(
            $request,
            $response,
            $logger
        );
    }

    /**
     * Displays the registration form.
     *
     * @return RedirectResponse|string
     */
    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        echo $this->view('layout/header_none');
        echo $this->view('auth/register');
        echo $this->view('layout/footer_none');

        return true;
    }

    public function guide_register()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        $NAVER_REQUEST_URL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_KEY."&redirect_uri=".urlencode(base_url().'Api/naver');
        $KAKAO_REQUEST_URL = "https://kauth.kakao.com/oauth/authorize?client_id=".KAKAO_CLIENT_KEY."&redirect_uri=".urlencode(base_url().'Api/kakao').'&response_type=code';

        $view_data = [
                'NAVER_REQUEST_URL' => $NAVER_REQUEST_URL
            ,   'KAKAO_REQUEST_URL' => $KAKAO_REQUEST_URL
        ];


        echo $this->view('layout/header_none');
        echo $this->view('auth/guide_register',$view_data);
        echo $this->view('layout/footer_none');

        return true;
    }

    /**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

//        log_message('error' , 'RegisterController::registerAction formdata > '. json_encode($this->request->getPost() , JSON_UNESCAPED_UNICODE) );

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();

        $aInput                 = $this->request->getPost($allowedPostFields);
//        $aInput['sms_yn']       = $this->request->getPost('sms_yn') ? 'Y' : 'N';
//        $aInput['email_yn']     = $this->request->getPost('email_yn') ? 'Y' : 'N';
        $aInput['advert_yn']    = $this->request->getPost('advert_yn') ? 'Y' : 'N';

        if($aInput['advert_yn'] == 'Y'){
            $aInput['advert_date'] = date('YmdHis');
        }
//        log_message('error' , 'RegisterController::registerAction upsertdata > '. json_encode($aInput , JSON_UNESCAPED_UNICODE) );
        $user->fill($aInput);

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);

        Events::trigger('register', $user);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->route('auth-action-show');
        }

        // Set the user active
        $user->activate();

        $authenticator->completeLogin($user);

        // Success!
        return redirect()->to('/register/complete')->with('login_id', $user->login_id);
    }

    public function registerAction_CmC(): RedirectResponse
    {

        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

//        log_message('error' , 'RegisterController::registerAction_CmC formdata > '. json_encode($this->request->getPost() , JSON_UNESCAPED_UNICODE) );

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        {//꼬망세연동회원 인 경우
            // strong_password 제거 241112 황기석
            $rules['password']['rules'] = 'required|max_byte[72]';

            //아이디 최소 길이 3자로 변경
            foreach ($rules['login_id']['rules'] as $k => $v) {
                if($v == 'min_length[6]') unset($rules['login_id']['rules'][$k]);
            }
            $rules['login_id']['rules'][] = 'min_length[3]';

        }

//        if(isTest()){
//            zsView($rules);
//            zsView($this->request->getPost());
//            exit;
//        }

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->to('/CmcSync?id='.$this->request->getPost('cmc_vcID'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();

        $aInput                 = $this->request->getPost($allowedPostFields);
//        $aInput['sms_yn']       = $this->request->getPost('sms_yn') ? 'Y' : 'N';
//        $aInput['email_yn']     = $this->request->getPost('email_yn') ? 'Y' : 'N';
        $aInput['advert_yn']    = $this->request->getPost('advert_yn') ? 'Y' : 'N';
        $aInput['s_use_date']   = $this->request->getPost('s_use_date') ?? '';
        $aInput['e_use_date']   = $this->request->getPost('e_use_date') ?? '';
//        $aInput['s_use_date']   = '';
//        $aInput['e_use_date']   = '';
        $aInput['cmc_vcID']     = $this->request->getPost('cmc_vcID') ?? '';

        if($aInput['advert_yn'] == 'Y'){
            $aInput['advert_date'] = date('YmdHis');
        }

//        log_message('error' , 'RegisterController::registerAction_CmC upsertdata > '. json_encode($aInput , JSON_UNESCAPED_UNICODE) );
        $user->fill($aInput);

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);

        Events::trigger('register', $user);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->route('auth-action-show');
        }

        // Set the user active
        $user->activate();

        $authenticator->completeLogin($user);


        session()->set(['s_use_date' => $aInput['s_use_date'] , 'e_use_date' => $aInput['e_use_date'] , 'isPay' => true]);

        // Success!
        return redirect()->to('/register/complete')->with('login_id', $user->login_id);
    }


    //회원가입 완료
    public function complete()
    {
        $login_id = session('login_id');

//        if(empty($login_id)) return redirect()->to('/');

        echo $this->view('layout/header_none');
        echo $this->view('auth/complete' , ['login_id' => $login_id]);
        echo $this->view('layout/footer_none');

        return true;

    }

    public function email_overlap()
    {

        $login_id = session('login_id');
        if(!$login_id && empty($test)) return redirect()->to('/');

        $user_model = new UserModel();
        $aInfo = $user_model->asArray()->find($login_id);

        if(!$aInfo  && empty($test)) return redirect()->to('/');


        echo $this->view('layout/header_none');
        echo $this->view('auth/email_overlap' , ['aInfo' => $aInfo]);
        echo $this->view('layout/footer_none');

        return true;

    }


    public function check_value(): ResponseInterface
    {

        $login_id = $this->request->getPost('login_id');
        $email = $this->request->getPost('email');
        $check_type = $this->request->getPost('check_type');

        if( $login_id == '' && $email == ''){
            $ret = ['success' => false , 'msg' => '필수입력정보가 없습니다.' , '_csrf' => csrf_hash() ];
            return $this->response->setJSON($ret);
        }


        if($login_id){

            if($check_type == 'cmc'){ //꼬망세 연동 회원인 경우 아이디가 최소자리를 변경
                $rules = [
                    'login_id' => [
                        'label' => 'Auth.login_id'
                        ,   'rules' => [ 'required', 'max_length[60]', 'min_length[3]', 'regex_match[/\A[a-zA-Z0-9_\.]+\z/]' ]
                    ]
                ];
            }else{
                $rules = [
                    'login_id' => [
                            'label' => 'Auth.login_id'
                        ,   'rules' => [ 'required', 'max_length[60]', 'min_length[6]', 'regex_match[/\A[a-zA-Z0-9_\.]+\z/]' ]
                    ]
                ];
            }

        } else {
            $rules = [
                'email' => [
                        'label' => 'Auth.email'
                    ,   'rules' => [  'required', 'max_length[254]', 'valid_email' ]
                ]
            ];
        }

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            $error_msgs = $this->validator->getErrors();

            $error_msg = '';
            foreach ($error_msgs as $k => $msg)  $error_msg = $msg;

            $ret = ['success' => false, 'msg' => $error_msg, '_csrf' => csrf_hash()];
            return $this->response->setJSON($ret);
        }

        $user_model = new UserModel();
        if($login_id) {
            $oUserInfo = $user_model->setTable('tb_user')->where('login_id', $login_id)->first();
            $type = '아이디';
        } else if($email) {
            $oUserInfo = $user_model->setTable('tb_user')->where('user_email', $email)->first();
            $type = '이메일';
        }

        if( $oUserInfo ) $ret = ['success' => false, 'msg' => '같은 '.$type.'이(가) 존재합니다.', '_csrf' => csrf_hash()];
        else  $ret = ['success' => true, 'msg' => '사용가능한 '.$type.'입니다.', '_csrf' => csrf_hash()];

        return $this->response->setJSON($ret);

    }


}
