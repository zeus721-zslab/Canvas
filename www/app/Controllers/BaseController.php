<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['auth','custom'];

    protected $session;

    private $test_ip = [];

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();

        $this->session = \Config\Services::session();
        //load helpers
        helper($this->helpers);

//        if(!in_array($this->request->getServer('REMOTE_ADDR') , $this->test_ip)){
//            return $this->show404();
//        }

    }

    public function _header_ctgr($type = '' , $data = [])
    {

        $data['type'] = $type;
        $data['search_text'] = isset($data['search_text']) ? $data['search_text'] : '';
        $data['search_type'] = isset($data['search_type']) ? $data['search_type'] : '';

        $data['user'] = new \stdClass();
        $data['menu_list'] = MENU_LIST;
        $data['site_name'] = setting('App.site_name');

        if( auth()->loggedIn() )
        {
            $data['user'] = auth()->getUser();
        }

        echo view('layout/header_ctgr' , $data);

    }

    public function _header($isNone = false , $data = [])
    {

        $data['search_text'] = isset($data['search_text']) ? $data['search_text'] : '';
        $data['search_type'] = isset($data['search_type']) ? $data['search_type'] : '';

        $data['user'] = new \stdClass();
        $data['menu_list'] = MENU_LIST;
        $data['site_name'] = setting('App.site_name');

        if( auth()->loggedIn() )
        {
            $data['user'] = auth()->getUser();
        }

        if($isNone){
            echo view('layout/header_none' , $data);
        }else{
            echo view('layout/header' , $data);
        }


    }

    public function _footer($isNone = false , $data = [])
    {

        $data['user'] = new \stdClass();

        if( auth()->loggedIn() )
        {
            $data['user'] = auth()->getUser();
            
            $aUserInfo = $data['user']->toArray();
            //현재 세션이 유료회원이 아니고, 회원정보에 사용종료일이 남아 있다면 [ 무통장입금 > 입금완료 후 대상 세션 갱신 ]
            if(!$this->session->isPay && $aUserInfo['e_use_date'] >= date('Ymd')){
                session()->set(['s_use_date' => $aUserInfo['s_use_date'] , 'e_use_date' => $aUserInfo['e_use_date'] , 'isPay' => true]);
            }

        }

        if($isNone) {
            echo view('layout/footer_none',$data);
        }else{
            echo view('layout/footer',$data);
        }


    }

    public function show404()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

}
