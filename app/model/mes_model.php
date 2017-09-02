<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\Tokens;

class MesModel
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

    public function Get($idemedica = '', $estado='A'){
        try
        {
            $result = array();
            $estado=strtoupper($estado);
            $sql = "EXEC dbo.SPK_MES @IDEMEDICA = ? , @ESTADO = ?";
            $stmt = sqlsrv_prepare($this->db, $sql, array(&$idemedica,&$estado));
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