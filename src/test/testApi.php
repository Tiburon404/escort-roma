<?php
/**
 * Test ApiTest
 * User: lmaterni
 * Date: 24/09/18
 * Time: 16.37
 */

require '../../src/controller/ApiController.php';


use PHPUnit\Framework\TestCase;
use Api as Api;
use Connection as Connection;

class testApiTest extends TestCase
{
    private $ctApi;

    public function __construct()
    {
        $this->ctApi= new arcadia\ApiController();
    }

    public function testAddMachine(){

        $json='{
        "message":{   
              "action":"addMachine",
              "idUtente":1   
              "data": {
                       "idFarm" : 1,
                       "name": "Trattore 1",
                       "description": "Trattore modello 1",
                       "radiusCurve": 45,
                       "driveShaft": 23.5,
                       "fullSpeed": 60
                      } 
              }
        }';

        $data=json_decode($json);

        $this->ctApi->executerequest($data);
   }
}