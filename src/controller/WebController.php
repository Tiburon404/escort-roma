<?php

namespace escort;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\views\Twig as View;
use escort\Errors as Errors;

require_once('../model/Logger.php');
require_once('../model/Escort.php');

class WebController
{
    private $model;
    private $errors;
    private $logger;
    private $container;



    public function __construct($container=null){
        $this->model = new Arcadia();
        $this->container = $container;
        $this->logger = new Logger('WebController');
        $this->errors = new Errors();
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function executeRequest($request, $response){
        return $this->container->view->render($response,'noData.twig');
    }

    public function home($request,$response){
        return $this->container->view->render($response,'home.twig');
    }

    public function Machine($request,$response){
        return $this->container->view->render($response,'Machine.twig');
    }
    
    public function addMachine($request,$response){
        return $this->container->view->render($response,'addMachine.twig');
    }

    public function addModMachine($request,$response){
        echo $request->getParam('machine_name');
        die();
        return $this->container->view->render($response,'addMachine.twig');
    }

    public function getAllMachine($request,$response){
        $result= $this->model->getAllMachine();

        if ($result['ESITO']==$this->errors->get_error('NO_ERROR')){
            return $this->container->view->render($response,'getAllMachine.twig',
                array('TITLE_MENU'=>'SMART AGRI GESTIONE MACCHINE',
                    'TITLE_SUB_MENU'=>'Lista Macchine',
                    'MACHINE_LIST'=>$result['DATA']
                ));
            }else{
                echo errore;
                var_dump($result['ESITO']);
            }
        }

    public function getMap($request,$response){
        return $this->container->view->render($response,'mapPolygon.twig');
    }


    
    
}