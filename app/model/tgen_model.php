<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\Tokens;

class TgenModel
{
    private $db;
    public $response;

    private $servidor;
    private $dbbase;

    public function __CONSTRUCT($servidor,$dbbase,$usuario,$clave) {
      try{
        $this->response = new Response();
        $this->db = Database::StartUp($servidor,$dbbase,$usuario,$clave);
        $this->servidor = $servidor;
        $this->dbbase = $dbbase;
      }catch(Exception $e){
        $this->response->setResponse(false, $e->getMessage());
        return $this->response;
      }
    }

    public function Get($tabla = '', $campo = '', $codigo = ''){
        try
        {
            $result = array();
            $query = "EXEC dbo.SPK_TGEN ?,?,?";
            $stmt = sqlsrv_prepare($this->db, $query, array(&$tabla,&$campo,&$codigo));
            if( !$stmt ) {
                $error="";
                if( ($errors = sqlsrv_errors() ) != null) {
                    foreach( $errors as $error ) {
                        $sqlstate = "SQLSTATE: ".$error[ 'SQLSTATE']."";
                        $code = "Code: ".$error['code']."";
                        $message =  "Message: ".$error['message'].".";
                        $error = $sqlstate.".- (".$code.") ".$message;
                    }
                }
                $this->response->setResponse(false);
                $this->response->message = $error; 
                return $this->response;
            }
            $data = array();
            $result = sqlsrv_execute($stmt);
            if( !$result ) {
                $error="";
                if( ($errors = sqlsrv_errors() ) != null) {
                    foreach( $errors as $error ) {
                        $sqlstate = "SQLSTATE: ".$error[ 'SQLSTATE']."";
                        $code = "Code: ".$error['code']."";
                        $message =  "Message: ".$error['message'].".";
                        $error = $sqlstate.".- (".$code.") ".$message;
                    }
                }
                $this->response->setResponse(false);
                $this->response->message = $error; 
                return $this->response;
            }
            // var_dump(sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC));
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $data[] = $row;
            }
            $this->response->setResponse(true);
            $this->response->result = $data;

            return $this->response;
        }
        catch(Exception $e)
        {
          $this->response->setResponse(false, $e->getMessage());
                return $this->response;
        }
    }

    
}