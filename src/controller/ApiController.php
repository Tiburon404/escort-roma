<?php

namespace escort;


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



require_once('../model/Api.php');
require_once('../model/Errors.php');
require_once('../model/Logger.php');


class ApiController
{
    private $logger;
    private $model;
    private $errors;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->model = new Api();
        $this->errors = new Errors();
        $this->logger = new Logger('ApiController');
    }


    /**
     * @param $request
     * @param $response
     * @throws \Exception
     */
    public function executeRequest($request)
    {

        $this->logger->debug("Eseguo richiesta");
        //var_dump($request);
        $parsedBody = $request->getParsedBody();

        //var_dump($request);
        //die();

        $data = $parsedBody['message'];

        switch ($data['action']) {
            case 'test':
                $result = $this->test($data);
                break;
            case 'getAllMachine':
                $result = $this->getAllMachine();
                break;
            case 'getMachine':
                $result = $this->getMachine($data);
                break;
            case 'delMachine':
                $result = $this->delMachine($data['data']);
                break;
            case 'addMachine':
                $result = $this->addMachine($data['data']);
                break;
            case 'modMachine':
                $result = $this->modMachine($data['data']);
                break;
            default:
                $result = $this->errors->get_error('ERR_NO_ACTION_SET');
                $this->logger->error("ACTION ->No action set");
                break;
        }
        
        $answer['message'] = $result;
        header('Content-Type: application/json');
        echo json_encode($result);

       } 

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getAllMachine(){
        try{

            $this->logger->debug('ACTION -> getAllMachine');
            $result['ESITO']=$this->errors->get_error('NO_ERROR');

            $result = $this->model->getAllMachine();

        }catch(Exception $e){
            $result['ESITO'] = $this->errors->get_error('ERR_DB_INSERT_TAKE_OVER');
            $result['MESSAGE'] = $e->getmessage();
            $this->logger->error($e->getmessage());
        }
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function getMachine($data){
        try{

            $this->logger->debug('ACTION -> getMachine');
            $result['ESITO']=$this->errors->get_error('NO_ERROR');

            $idMachine= intval($data['id']);

            $result = $this->model->getMachine($idMachine);

        }catch(Exception $e){
            $result['ESITO'] = $this->errors->get_error('ERR_DB_INSERT_TAKE_OVER');
            $result['MESSAGE'] = $e->getmessage();
            $this->logger->error($e->getmessage());
        }
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function delMachine($data){
        try{

            $this->logger->debug('ACTION -> delMachine');
            $result['ESITO']=$this->errors->get_error('NO_ERROR');


            $idMachine= intval($data['id']);

            $result = $this->model->delMachine($idMachine);

        }catch(Exception $e){
            $result['ESITO'] = $this->errors->get_error('ERR_DB_INSERT_TAKE_OVER');
            $result['MESSAGE'] = $e->getmessage();
            $this->logger->error($e->getmessage());
        }
        return $result;
    }



    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function addMachine($data){
        try{
            $this->logger->debug('ACTION -> addMachine');
            $result['ESITO']=$this->errors->get_error('NO_ERROR');


            $idFarm= intval($data['idFarm']);
            $name= $data['name'];
            $description= $data['description'];
            $radiusCurve= $data['radiusCurve'];
            $driveShaft= $data['driveShaft'];
            $fullSpeed= $data['fullSpeed'];

            $result = $this->model->addMachine($idFarm, $name, $description, $radiusCurve, $driveShaft, $fullSpeed);

        }catch(Exception $e){
            $result['ESITO'] = $this->errors->get_error('ERR_ADD_MACHINE');
            $result['MESSAGE'] = $e->getmessage();
            $this->logger->error($e->getmessage());
        }
        return $result;
    }


    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function modMachine($data){
        try{
            $this->logger->debug('ACTION -> modMachine');
            $result['ESITO']=$this->errors->get_error('NO_ERROR');

            $idMachine= intval($data['idMachine']);
            $name= $data['name'];
            $description= $data['description'];
            $radiusCurve= $data['radiusCurve'];
            $driveShaft= $data['driveShaft'];
            $fullSpeed= $data['fullSpeed'];

            $result = $this->model->modMachine($idMachine, $name, $description, $radiusCurve, $driveShaft, $fullSpeed);

        }catch(Exception $e){
            $result['ESITO'] = $this->errors->get_error('ERR_MOD_MACHINE');
            $result['MESSAGE'] = $e->getmessage();
            $this->logger->error($e->getmessage());
        }
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function test($data){
        try {
            $this->logger->debug('ACTION -> test');
            $result['ESITO']=$this->errors->get_error('NO_ERROR');

            //$result = $this->model->insertSurvey($idUser, $uuid, $idRoute, $startDate);

        } catch (Exception $e){
            $result['ESITO'] = $this->errors->get_error('ERR_DB_INSERT_TAKE_OVER');
            $result['MESSAGE'] = $e->getmessage();
            $this->logger->error($e->getmessage());
        }

        return $result;
    }

}