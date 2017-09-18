<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\Tokens;

class CitModel
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

    public function Get($fdesde, $fhasta, $idmedico, $libres = '0'){
        try
        {
            $result = array();
            $sql = "EXEC dbo.SPK_CIT @FDESDE = ? , @FHASTA = ?, @IDMEDICO = ?, @LIBRES = ?";
            // $this->response->setResponse(false);
            // $this->response->message = &$fdesde; 
            // return $this->response;
            $stmt = sqlsrv_prepare($this->db, $sql, array(&$fdesde,&$fhasta,&$idmedico,&$libres));
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

    public function GetByIdAfiliado($idafiliado, $cumplida = '0'){
        try
        {
            $result = array();
            $sql = "EXEC dbo.SPK_CIT  @IDAFILIADO = ?, @CUMPLIDA = ?";
            // $this->response->setResponse(false);
            // $this->response->message = &$fdesde; 
            // return $this->response;
            $stmt = sqlsrv_prepare($this->db, $sql, array(&$idafiliado, &$cumplida));
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

    /**
    *   Cancela una cita
    */
    public function CancelarCita($consecutivo){
        try
        {
            $result = array();
            
            $procedure_params = array(
                array(&$consecutivo, SQLSRV_PARAM_IN)
            );
            $sql = "EXEC dbo.SPK_CIT_DEL @CONSECUTIVO = ? ";
            // $this->response->setResponse(false, $afiliado['IDAFILIADO']);
            // return $this->response;
            $stmt = sqlsrv_prepare($this->db, $sql, $procedure_params);
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
            }else{
                $this->response->setResponse(true);
                $this->response->result = true;
            }

            return $this->response;
        }
        catch(Exception $e)
        {
          $this->response->setResponse(false, $e->getMessage());
                return $this->response;
        }
    }
    

    /**
    *   Registra una cita
    */
    public function Post($cita){
        try
        {
            $result = array();
            
            $procedure_params = array(
                array(&$cita['CONSECUTIVO'], SQLSRV_PARAM_IN),
                array(&$cita['IDAFILIADO'], SQLSRV_PARAM_IN),
                array(&$cita['IDMEDICO'], SQLSRV_PARAM_IN),
                array(&$cita['IDSERVICIO'], SQLSRV_PARAM_IN)
            );
            $sql = "EXEC dbo.SPK_CIT_ADD @CONSECUTIVO = ?, @IDAFILIADO = ?, @IDMEDICO = ?, @IDSERVICIO = ? ";
            // $this->response->setResponse(false, $afiliado['IDAFILIADO']);
            // return $this->response;
            $stmt = sqlsrv_prepare($this->db, $sql, $procedure_params);
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
            }else{
                $this->response->setResponse(true);
                $this->response->result = true;
            }

            return $this->response;
        }
        catch(Exception $e)
        {
          $this->response->setResponse(false, $e->getMessage());
                return $this->response;
        }
    }
}