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
use CodeIgniter\Shield\Authentication\Authenticators\Session; //원본
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\Shield\Traits\Viewable;
use CodeIgniter\Shield\Validation\ValidationRules;

class LoginController extends ShieldLogin
{
    use Viewable;

    /**
     * Displays the form the login to the site.
     *
     * @return RedirectResponse|string
     */
    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        $NAVER_REQUEST_URL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_KEY."&redirect_uri=".urlencode(base_url().'Api/naver');
        $KAKAO_REQUEST_URL = "https://kauth.kakao.com/oauth/authorize?client_id=".KAKAO_CLIENT_KEY."&redirect_uri=".urlencode(base_url().'Api/kakao').'&response_type=code';

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        $data = [
                'NAVER_REQUEST_URL' => $NAVER_REQUEST_URL
            ,   'KAKAO_REQUEST_URL' => $KAKAO_REQUEST_URL
        ];

        echo $this->view('layout/header_none');
        echo $this->view(setting('Auth.views')['login'] , $data);
        echo $this->view('layout/footer_none');
        return true;
    }

    /**
     * Attempts to log the user in.
     */
    public function loginAction(): RedirectResponse
    {
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        /** @var array $credentials */
        $credentials             = $this->request->getPost(setting('Auth.validFields')) ?? [];
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');
        $remember                = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);

        if (! $result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }

        // If an action has been defined for login, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')->withCookies();
        }



        session()->set('user_name',$result->extraInfo()->username);
        session()->set('user_email',$result->extraInfo()->user_email);
        session()->set('s_use_date',$result->extraInfo()->s_use_date);
        session()->set('e_use_date',$result->extraInfo()->e_use_date);
        session()->set('isPay',$result->extraInfo()->e_use_date >= date('Ymd'));



        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, list<string>|string>>
     */
    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();

        return $rules->getLoginRules();
    }

    /**
     * Logs the current user out.
     */
    public function logoutAction(): RedirectResponse
    {
        // Capture logout redirect URL before auth logout,
        // otherwise you cannot check the user in `logoutRedirect()`.
        $url = config('Auth')->logoutRedirect();
        log_message('error' , 'logoutAction');
        auth()->logout();

        //return redirect()->to($url)->with('message', lang('Auth.successLogout'));
        return redirect()->to($url);
    }

    public function modifyCheck() : RedirectResponse
    {

        if (!auth()->loggedIn()) {
            return redirect()->to('login')->with('error','로그인 후 다시 시도해주세요.');
        }

        $model                   = new UserModel();
        $oUserInfo               = $model->setTable('tb_user')->where('id' , auth()->id())->first();

        $credentials             = $this->request->getPost(setting('Auth.validFields')) ?? [];
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');
        $credentials['login_id'] = $oUserInfo->login_id;

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();
        $result = $authenticator->check($credentials);

        if (! $result->isOK()) {
            return redirect()->to('/My/info')->withInput()->with('error', '비밀번호를 확인해주세요!');
        }

        return redirect()->to('/My/upsertForm')->with('encrypt_data', md5(microtime()));

    }

}