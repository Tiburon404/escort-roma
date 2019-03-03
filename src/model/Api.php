<?php

namespace escort;

use PDO;
use PDOException;

require_once('../model/Logger.php');
require_once('../model/Connection.php');
require_once('Errors.php');

class Api
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

        return $response;

    }


    /**
     * @param $idMachine
     * @return mixed
     * @throws \Exception
     */
    public function getMachine($idMachine){

        $response['ESITO'] = $this->errors->get_error('NO_ERROR');

        try {
            $result = array();
            $db = new Connection();
            $this->PDO = $db->connect();
            if ($this->PDO !=null) {

                $stmt = $this->PDO->prepare($this->queryList['getMachine']);
                $stmt->bindValue(':idMachine', $idMachine, \PDO::PARAM_INT);
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

        return $response;

    }


    /**
     * @param $idMachine
     * @return mixed
     * @throws \Exception
     */
    public function delMachine($idMachine){

        $response['ESITO'] = $this->errors->get_error('NO_ERROR');

        try {
            $result = array();
            $db = new Connection();
            $this->PDO = $db->connect();
            if ($this->PDO !=null) {

                $stmt = $this->PDO->prepare($this->queryList['delMachine']);
                $stmt->bindValue(':idMachine', $idMachine, \PDO::PARAM_INT);
                $stmt->execute();


            }
            $this->PDO = null;
            $response['DATA'] = $result;

        }catch(\PDOException $pdoe) {
            //$this->db->rollBack();
            $response['ESITO'] = $this->errors->get_error('ERR_DEL_MACHINE');
            $response['MESSAGE'] = $pdoe->getMessage();
        } catch (Exception $e){
            $response['ESITO'] = $this->errors->get_error('ERR_DEL_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        } catch (\ErrorException $e){
            $response['ESITO'] = $this->errors->get_error('ERR_DEL_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        }

        return $response;

    }



    /**
     * @param $idFarm
     * @param $name
     * @param $description
     * @param $radiusCurve
     * @param $driveShaft
     * @param $fullSpeed
     * @return mixed
     * @throws \Exception
     */
    public function addMachine($idFarm, $name, $description, $radiusCurve, $driveShaft, $fullSpeed){

        $response['ESITO'] = $this->errors->get_error('NO_ERROR');

        try {
            $result = array();
            $db = new Connection();
            $this->PDO = $db->connect();
            if ($this->PDO !=null) {

                $stmt = $this->PDO->prepare($this->queryList['addMachine']);

                $stmt->bindValue(':idFarm', $idFarm, \PDO::PARAM_INT);
                $stmt->bindValue(':Name', $name,\PDO::PARAM_STR);
                $stmt->bindValue(':Description', $description,\PDO::PARAM_STR);
                $stmt->bindValue(':RadiusCurve', $radiusCurve);
                $stmt->bindValue(':DriveShaft', $driveShaft);
                $stmt->bindValue(':FullSpeed', $fullSpeed);

                $stmt->execute();

                if (0==$this->PDO->lastInsertId()){
                    $result['ESITO']= $this->errors->get_error('ERR_ADD_MACHINE');
                }

            }
            $this->PDO = null;
            $response['DATA'] = '';

        }catch(\PDOException $pdoe) {
            //$this->db->rollBack();
            $response['ESITO'] = $this->errors->get_error('ERR_ADD_MACHINE');
            $response['MESSAGE'] = $pdoe->getMessage();
        } catch (Exception $e){
            $response['ESITO'] = $this->errors->get_error('ERR_ADD_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        } catch (\ErrorException $e){
            $response['ESITO'] = $this->errors->get_error('ERR_ADD_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        }

        return $response;
    }


    /**
     * @param $idMachine
     * @param $idFarm
     * @param $name
     * @param $description
     * @param $radiusCurve
     * @param $driveShaft
     * @param $fullSpeed
     * @return mixed
     * @throws \Exception
     */
    public function modMachine($idMachine, $name, $description, $radiusCurve, $driveShaft, $fullSpeed){

        $response['ESITO'] = $this->errors->get_error('NO_ERROR');


        try {
            $result = array();
            $db = new Connection();
            $this->PDO = $db->connect();
            if ($this->PDO !=null) {

                $stmt = $this->PDO->prepare($this->queryList['modMachine']);

                $stmt->bindValue(':idMachine', $idMachine, \PDO::PARAM_INT);
                $stmt->bindValue(':Name', $name,\PDO::PARAM_STR);
                $stmt->bindValue(':Description', $description,\PDO::PARAM_STR);
                $stmt->bindValue(':radiusCurve', $radiusCurve);
                $stmt->bindValue(':driveShaft', $driveShaft);
                $stmt->bindValue(':fullSpeed', $fullSpeed);

                $stmt->execute();

                if ($stmt->rowCount()<=0) {
                    $result['ESITO']= $this->errors->get_error('ERR_MOD_MACHINE');
                }

            }
            $this->PDO = null;
            $response['DATA'] = '';

        }catch(\PDOException $pdoe) {
            //$this->db->rollBack();
            $response['ESITO'] = $this->errors->get_error('ERR_MOD_MACHINE');
            $response['MESSAGE'] = $pdoe->getMessage();
        } catch (Exception $e){
            $response['ESITO'] = $this->errors->get_error('ERR_MOD_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        } catch (\ErrorException $e){
            $response['ESITO'] = $this->errors->get_error('ERR_MOD_MACHINE');
            $response['MESSAGE'] = $e->getMessage();
            $this->logger->error($e->getMessage());
        }

        return $response;
    }
}