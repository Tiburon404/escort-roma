<?php
header("Access-Control-Allow-Origin: *");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPUnit\Util\Json;




require '../vendor/autoload.php';
require '../controller/WebController.php';
require '../controller/ApiController.php';
require_once('../model/Logger.php');

//$logger = new Logger('index');

/*modifico l'handler degli errori in modo tale che mi cosideri i php warning come
ErrorException per riuscire a catturarli nel try-catch e poterni vedere nel file di log*/
set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context){
    throw new ErrorException( $err_msg, 0, $err_severity, $err_file, $err_line );
},
    E_WARNING);

try{
    //// instanzio l'oggetto App
    $app = new \Slim\App(['settings' => [
        'displayErrorDetails' => true,
        'debug'               => true]
    ]);

    $container = $app->getContainer();

    $container['logger'] = function($c) {
        $logger = new Logger();
        return $logger;
    };

    // Dico al container dove sono le view di Twig
    $container['view'] = function ($c) {
        $view = new \Slim\Views\Twig('../view/', [
            'cache' => false]);
        $view['assets'] = $c['request']->getUri()->getBaseURL();

        //Define assets
        //-------------
        $view['assetCSS']=$c['request']->getUri()->getBaseUrl()."/css";
        $view['assetJS']=$c['request']->getUri()->getBaseUrl()."/js";
        $view['assetIMAGES']=$c['request']->getUri()->getBaseUrl()."/images";
        $view['assetFONTS']=$c['request']->getUri()->getBaseUrl()."/fonts";

        return $view;
    };


    // Rotte GET
    //----------------------------------------------------------------------------------------------------
    $app->get('/', function (Request $request, Response $response) {
        $webController = new escort\WebController($this);
        $webController->home($request,$response);
    });
    
    $app->get('/Machine', function (Request $request, Response $response) {
        $webController = new arcadia\WebController($this);
        $webController->Machine($request,$response);
    });

    $app->get('/addMachine', function (Request $request, Response $response) {
        $webController = new arcadia\WebController($this);
        $webController->addMachine($request,$response);
    });

    $app->get('/delMachine', function (Request $request, Response $response) {
        $webController = new arcadia\WebController($this);
        $webController->delMachine($request,$response);
    });

    $app->get('/getAllMachine', function (Request $request, Response $response) {
        $webController = new arcadia\WebController($this);
        $webController->getAllMachine($request,$response);
    });

    $app->get('/mapPolygon', function (Request $request, Response $response) {
        $webController = new escort\WebController($this);
        $webController->getMap($request,$response);
    });




    //ROTTE POST
    //----------------------------------------------------------------------------------------------------
    $app->post('/addMachine',function (Request $request, Response $response, $args) {
        $apiController = new arcadia\ApiController();
        $data=$this->request;
        $apiController->executeRequest($data);
    });

    $app->post('/delMachine',function (Request $request, Response $response, $args) {
        $apiController = new arcadia\ApiController();
        $apiController->executeRequest($data);
    });

    $app->post('/getAllMachine',function (Request $request, Response $response, $args) {
        $apiController = new arcadia\ApiController();
        $apiController->executeRequest($data);
    });

    $app->post('/api',function (Request $request, Response $response, $args) {
        $apiController = new arcadia\ApiController();
        $apiController->executeRequest($request);
    });

    $app->post('/addModMachine',function (Request $request, Response $response, $args) {
        $apiController = new arcadia\ApiController();
        $apiController->executeRequest($request);
    });
    //----------------------------------------------------------------------------------------------------------
    $app->run();
    
} catch(ErrorException $e){
    $logger->error($e->getMessage());
}