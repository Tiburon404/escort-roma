<?php
/**
 * Enumeratore errori
 * @author Tiburon
 * @version 1.0.0
 * @copyright Tiburon
 */

namespace escort;

class Errors
{
    private static $NO_ERROR=array('number'=>0,'description'=>'');
    private static $ERR_UNKNOW=array('number' => -1, 'description' => 'Errore sconosciuto');
    private static $ERR_NO_ACTION_SET=array('number' => -2, 'description' => 'Nessuna azione specificata');
    private static $ERR_DB_CONNECT=array('number'=> -101,'description'=>'Errore durante la connessione al Database');
    private static $ERR_LOGIN_USER=array('number'=> -102,'description'=>'Errore durante il login utente');
    private static $ERR_DB_LOGGER=array('number' => -103,'description' => 'Errore durante la scrittura del Log nel DB');
    private static $ERR_USER_PWD=array('number'=> -113,'description'=>'Username o password errati');
    private static $ERR_LOGGER=array('number'=> -114,'description'=>'Errore durante la scrittura del Log');
    private static $ERR_ADD_MACHINE=array('number'=> -115,'description'=>'Errore durante aggiunta  del mezzo');
    private static $ERR_ADD_FARM=array('number'=> -116,'description'=>'Errore durante aggiunta della farm');
    private static $ERR_GET_MACHINE=array('number'=> -117,'description'=>'Errore durante il recupero  del/dei  mezzo/i');
    private static $ERR_GET_FARM=array('number'=> -119,'description'=>'Errore durante il recupero  dell"/delle  azienda/e');
    private static $ERR_DEL_MACHINE=array('number'=> -118,'description'=>'Errore durante eliminazione del mezzo');
    private static $ERR_MOD_MACHINE=array('number'=> -119,'description'=>'Errore durante la modifica del mezzo');
    private static $ERR_GET_WORKS = array('number' => -120,'description' => 'Errore durante il recupero dei lavori');
    private static $ERR_DEL_WORK = array('number' => -121,'description' => 'Errore durante Eliminazione Lavoro');
    private static $ERR_MOD_FARM=array('number'=> -122,'description'=>'Errore durante la modifica della Azienda');
    private static $ERR_DEL_FARM = array('number' => -123,'description' => 'Errore durante Eliminazione Azienda');
    private static $ERR_DEL_ACTION = array('number' => -124,'description' => 'Errore durante Eliminazione Azione');
    private static $ERR_ADD_ACTION=array('number'=> -125,'description'=>'Errore durante aggiunta  della Azione');
    private static $ERR_MOD_ACTION=array('number'=> -126,'description'=>'Errore durante la modifica della Azione');
    private static $ERR_GET_ACTION = array('number' => -127,'description' => 'Errore durante il recupero della Azione');
    private static $ERR_ADD_WORK=array('number'=> -128,'description'=>'Errore durante aggiunta del Lavoro');
    private static $ERR_MOD_WORK=array('number'=> -129,'description'=>'Errore durante la modifica del Lavoro');

    public function get_error($error){
        try{
            return self::$$error;
        }catch (\Exception $e){
            return self::$ERR_UNKNOW;
        }
    }
}
