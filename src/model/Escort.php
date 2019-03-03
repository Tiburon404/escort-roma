<?php

namespace escort;

use PDO;
use PDOException;

require_once('../model/Logger.php');
require_once('../model/Connection.php');
require_once('Errors.php');

class Arcadia
{
    private $queryList;
    private $PDO;
    private $logger;
    private $errors;

    public function __construct()
    {
        $queryINI = parse_ini_file("../EscortQuery.ini", true);
        $this->queryList = $queryINI['queryAPI'];
        $this->logger = new Logger('Api');
        $this->errors = new Errors();

    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getAllMachine(){

        $response['ESITO'] = $this->errors->get_error('NO_ERROR');
        $response['MESSAGE'] ="";

        try {
            $result = array();
            $db = new Connection();
            $this->PDO = $db->connect();
            if ($this->PDO !=null) {

                $stmt = $this->PDO->prepare($this->queryList['getAllMachine']);

                $stmt->execute();
                $rs=$stmt->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0;$i<count($rs);$i++){
                    array_push($result,$rs[$i]);
                }

            }
            $this->PDO = null;
            $response['DATA'] = $result;

        }catch(\PDOException $pdoe) {
            //$this->db->rollBack();
            $response['ESITO'] = $this->errors->get_error('ERR_GET_MACHINE');
            $response['MESSAGE'] = $pdoe->getMessage();
        } catch (Exception $e){
            $response['ESITO'] = $this->errors->get_error('ERR_GET_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        } catch (\ErrorException $e){
            $response['ESITO'] = $this->errors->get_error('ERR_GET_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        }
    }

}