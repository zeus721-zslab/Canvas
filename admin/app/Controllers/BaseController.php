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

    }

    public function _header($data = [])
    {

        $uri = service('uri');
        $uri_one = '';
        $uri_two = '';
        if($uri->getTotalSegments() > 0 && $uri->getSegment(1))
            $uri_one = $uri->getSegment(1);
        if($uri->getTotalSegments() > 1 && $uri->getSegment(2))
            $uri_two = $uri->getSegment(2);

        $data['active_menu'] = "{$uri_one}:{$uri_two}";

        echo view('layout/header' , $data);

    }

    public function _footer($data = [])
    {

        echo view('layout/footer',$data);

    }

    public function show404()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

}
