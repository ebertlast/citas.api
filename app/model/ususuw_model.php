<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\Tokens;

class UsusuwModel
{
    private $db;
    private $table = 'ususuw';
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

    public function Get($usuario){
        try
        {
            $result = array();
            $accion = 'R';
            $query = "EXEC dbo.SPK_USUSUW ?";
            $stmt = sqlsrv_prepare($this->db, $query, array(&$accion));
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

    public function GetByDocumento($idafiliado,$tipo_ident){
        try
        {
            $result = array();
            $accion = 'R';
            $sql = "EXEC SPK_USUSUW @ACTION=?, @TIPO_DOC=?, @IDAFILIADO=?";
            $stmt = sqlsrv_prepare($this->db, $sql, array(&$accion, &$tipo_ident, &$idafiliado));
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

    public function Put($usuario){
        try
        {
            $result = array();
            $accion = 'C';
            $sql = "EXEC dbo.SPK_USUSUW @ACTION = ?, @USUARIO = ?, @CLAVE = ?, @EMAIL = ?, @ACTIVO = ?,  @TIPO_DOC  = ?, @IDAFILIADO  = ?";
            // $this->response->setResponse(false);
            // $this->response->message = $usuario['IDAFILIADO']; 
            // return $this->response;
            $activo=(string)$usuario['ACTIVO'];
            $procedure_params = array(
                array(&$accion, SQLSRV_PARAM_IN),
                array(&$usuario['USUARIO'], SQLSRV_PARAM_IN),
                array(&$usuario['CLAVE'], SQLSRV_PARAM_IN),
                array(&$usuario['EMAIL'], SQLSRV_PARAM_IN),
                array(&$activo, SQLSRV_PARAM_IN),
                array(&$usuario['TIPO_DOC'], SQLSRV_PARAM_IN),
                array(&$usuario['IDAFILIADO'], SQLSRV_PARAM_IN)
            );
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
                // return $this->response;
            }else{
                $this->response->setResponse(true);
                $this->response->result = true;

                // $data = array();
                // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                //     $data[] = $row;
                // }
                // $this->response->result = $data;
                $this->Get($usuario['USUARIO']);
            }
           

            return $this->response;
        }
        catch(Exception $e)
        {
          $this->response->setResponse(false, $e->getMessage());
                return $this->response;
        }
    }

    public function PutDEPRECATED($usuario){
        try
        {
            $result = array();
            $accion = 'C';
            $sql = "EXEC dbo.SPK_USUSUW @ACTION = ?, @USUARIO = ?, @CLAVE = ?, @EMAIL = ?, @ACTIVO = ?,  @TIPO_DOC  = ?, @IDAFILIADO  = ?";
            $activo=(string)$usuario['ACTIVO'];
            $procedure_params = array(
                array(&$accion, SQLSRV_PARAM_IN),
                array(&$usuario['USUARIO'], SQLSRV_PARAM_IN),
                array(&$usuario['CLAVE'], SQLSRV_PARAM_IN),
                array(&$usuario['EMAIL'], SQLSRV_PARAM_IN),
                array(&$activo, SQLSRV_PARAM_IN),
                array(&$usuario['TIPO_DOC'], SQLSRV_PARAM_IN),
                array(&$usuario['IDAFILIADO'], SQLSRV_PARAM_IN)
            );
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
                $this->response->setResponse(false);
                $this->response->message = 'Ebert'; 
                return $this->response;
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
                 $this->response->setResponse(false);
                $this->response->message = 'Manuel'; 
                return $this->response;

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

    public function Activar($usuario,$key){
        try
        {
            $result = array();
            $accion = 'A';
            $sql = "EXEC dbo.SPK_USUSUW @ACTION = ?, @USUARIO = ?, @KEYACTIVATE = ?";
            // $this->response->setResponse(false);
            // $this->response->message = $usuario['IDAFILIADO']; 
            // return $this->response;
            $procedure_params = array(
                array(&$accion, SQLSRV_PARAM_IN),
                array(&$usuario, SQLSRV_PARAM_IN),
                array(&$key, SQLSRV_PARAM_IN)
            );
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
                // return $this->response;
            }else{
                $this->response->setResponse(true);
                $this->response->result = true;

                // $data = array();
                // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                //     $data[] = $row;
                // }
                // $this->response->result = $data;
                $this->Get($usuario);
            }
           

            return $this->response;
        }
        catch(Exception $e)
        {
          $this->response->setResponse(false, $e->getMessage());
                return $this->response;
        }
    }

    public function Autenticar($usuario, $clave){
        try
        {
            $result = array();
            $accion = 'R';
            $query = "EXEC dbo.SPK_USUSUW @ACTION = ?, @USUARIO = ?, @CLAVE = ?";
            $stmt = sqlsrv_prepare($this->db, $query, array(&$accion, &$usuario, &$clave));
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