<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\Tokens;

class AfiModel
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

    public function Get($idafiliado = '', $tipo_ident = ''){
        try
        {
            $result = array();
            $query = "EXEC dbo.SPK_AFI ?,?";
            $stmt = sqlsrv_prepare($this->db, $query, array(&$idafiliado,&$tipo_ident));
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

    public function Post($afiliado){
        try
        {
            $result = array();
            
            $procedure_params = array(
                array(&$afiliado['IDAFILIADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['PAPELLIDO'], SQLSRV_PARAM_IN),
                array(&$afiliado['SAPELLIDO'], SQLSRV_PARAM_IN),
                array(&$afiliado['PNOMBRE'], SQLSRV_PARAM_IN),
                array(&$afiliado['SNOMBRE'], SQLSRV_PARAM_IN),
                array(&$afiliado['TIPO_DOC'], SQLSRV_PARAM_IN),
                array(&$afiliado['DOCIDAFILIADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDALTERNA'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDAFILIADOPPAL'], SQLSRV_PARAM_IN),
                array(&$afiliado['GRUPO_SANG'], SQLSRV_PARAM_IN),
                array(&$afiliado['ESTADO_CIVIL'], SQLSRV_PARAM_IN),
                array(&$afiliado['GRUPOETNICO'], SQLSRV_PARAM_IN),
                array(&$afiliado['SEXO'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDPARENTESCO'], SQLSRV_PARAM_IN),
                array(&$afiliado['LOCALIDAD'], SQLSRV_PARAM_IN),
                array(&$afiliado['DIRECCION'], SQLSRV_PARAM_IN),
                array(&$afiliado['TELEFONORES'], SQLSRV_PARAM_IN),
                array(&$afiliado['CIUDAD'], SQLSRV_PARAM_IN),
                array(&$afiliado['ZONA'], SQLSRV_PARAM_IN),
                array(&$afiliado['CODENTIDADANTERIOR'], SQLSRV_PARAM_IN),
                array(&$afiliado['ESTADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['FECHAULTESTADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDSEDE'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDPROVEEDOR'], SQLSRV_PARAM_IN),
                array(&$afiliado['FNACIMIENTO'], SQLSRV_PARAM_IN),
                array(&$afiliado['FECHAAFILSGSSS'], SQLSRV_PARAM_IN),
                array(&$afiliado['ACT_ECONO'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDESCOLARIDAD'], SQLSRV_PARAM_IN),
                array(&$afiliado['INDCOTIZANTE'], SQLSRV_PARAM_IN),
                array(&$afiliado['ULTIMOANOAPROBADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['INCAPACIDADLABORAL'], SQLSRV_PARAM_IN),
                array(&$afiliado['TIPODISCAPACIDAD'], SQLSRV_PARAM_IN),
                array(&$afiliado['TIPOAFILIADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['GRUPOATESPECIAL'], SQLSRV_PARAM_IN),
                array(&$afiliado['CABEZADEFAMILIA'], SQLSRV_PARAM_IN),
                array(&$afiliado['ASOCIADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['TIENEOBS'], SQLSRV_PARAM_IN),
                array(&$afiliado['CAMPOUSUARIO1'], SQLSRV_PARAM_IN),
                array(&$afiliado['FECHAUVISITA'], SQLSRV_PARAM_IN),
                array(&$afiliado['CONSANGUINIDAD'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDADMINISTRADORA'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDCAUSAL'], SQLSRV_PARAM_IN),
                array(&$afiliado['FECHACAUSAL'], SQLSRV_PARAM_IN),
                array(&$afiliado['CLASIFPC'], SQLSRV_PARAM_IN),
                array(&$afiliado['NIVELSOCIOEC'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDPLAN'], SQLSRV_PARAM_IN),
                array(&$afiliado['FECHAAFILIACION'], SQLSRV_PARAM_IN),
                array(&$afiliado['NUMCARNET'], SQLSRV_PARAM_IN),
                array(&$afiliado['CIUDADDOC'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDEMPLEADOR'], SQLSRV_PARAM_IN),
                array(&$afiliado['SEMANASCOT'], SQLSRV_PARAM_IN),
                array(&$afiliado['CARNETIZADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['FECHACARNET'], SQLSRV_PARAM_IN),
                array(&$afiliado['CONSCERTIFICADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['CIUDADNAC'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDOCUPACION'], SQLSRV_PARAM_IN),
                array(&$afiliado['NACIONALIDAD'], SQLSRV_PARAM_IN),
                array(&$afiliado['CELULAR'], SQLSRV_PARAM_IN),
                array(&$afiliado['DIRECCIONLAB'], SQLSRV_PARAM_IN),
                array(&$afiliado['TELEFONOLAB'], SQLSRV_PARAM_IN),
                array(&$afiliado['CNSAFIAA'], SQLSRV_PARAM_IN),
                array(&$afiliado['SISBENNUMFICHA'], SQLSRV_PARAM_IN),
                array(&$afiliado['SISBENFECHAFICHA'], SQLSRV_PARAM_IN),
                array(&$afiliado['SISBENPUNTAJE'], SQLSRV_PARAM_IN),
                array(&$afiliado['SISBENNUCLEOFAM'], SQLSRV_PARAM_IN),
                array(&$afiliado['SISBENGRUPOB'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDCONTRATO'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDBARRIO'], SQLSRV_PARAM_IN),
                array(&$afiliado['CLASEAFILIACIONARS'], SQLSRV_PARAM_IN),
                array(&$afiliado['FORMULARIO'], SQLSRV_PARAM_IN),
                array(&$afiliado['EMAIL'], SQLSRV_PARAM_IN),
                array(&$afiliado['NORADICACION'], SQLSRV_PARAM_IN),
                array(&$afiliado['FECHARADICACION'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDTIPOAFILIACION'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDCLASEAFILIACION'], SQLSRV_PARAM_IN),
                array(&$afiliado['V_FORMULARIO'], SQLSRV_PARAM_IN),
                array(&$afiliado['SISBENNIVEL'], SQLSRV_PARAM_IN),
                array(&$afiliado['CNSXCPA'], SQLSRV_PARAM_IN),
                array(&$afiliado['FESTADO'], SQLSRV_PARAM_IN),
                array(&$afiliado['OKBD'], SQLSRV_PARAM_IN),
                array(&$afiliado['USUARIOBD'], SQLSRV_PARAM_IN),
                array(&$afiliado['NACIMIENTO'], SQLSRV_PARAM_IN),
                array(&$afiliado['ITFC'], SQLSRV_PARAM_IN),
                array(&$afiliado['CNSITFC'], SQLSRV_PARAM_IN),
                array(&$afiliado['TIPOSUBSIDIO'], SQLSRV_PARAM_IN),
                array(&$afiliado['COBERTURA_SALUD'], SQLSRV_PARAM_IN),
                array(&$afiliado['TIPOAFILIADO2'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDAFI_TITULAR'], SQLSRV_PARAM_IN),
                array(&$afiliado['ES_NN'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDESPECIAL'], SQLSRV_PARAM_IN),
                array(&$afiliado['MTRIAGE'], SQLSRV_PARAM_IN),
                array(&$afiliado['FTRIAGE'], SQLSRV_PARAM_IN),
                array(&$afiliado['GRUPOPOB'], SQLSRV_PARAM_IN),
                array(&$afiliado['IDSEDETRIAGE'], SQLSRV_PARAM_IN),
                array(&$afiliado['F_ACTUALIZA'], SQLSRV_PARAM_IN),
                array(&$afiliado['PRIORIDAD'], SQLSRV_PARAM_IN)
            );
            $sql = "EXEC dbo.SPK_AFI_ADD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
            $sql = "EXEC dbo.SPK_AFI_ADD @IDAFILIADO = ?, @PAPELLIDO = ?, @SAPELLIDO = ?, @PNOMBRE = ?, @SNOMBRE = ?, @TIPO_DOC = ?, @DOCIDAFILIADO = ?, @IDALTERNA = ?, @IDAFILIADOPPAL = ?, @GRUPO_SANG = ?, @ESTADO_CIVIL = ?, @GRUPOETNICO = ?, @SEXO = ?, @IDPARENTESCO = ?, @LOCALIDAD = ?, @DIRECCION = ?, @TELEFONORES = ?, @CIUDAD = ?, @ZONA = ?, @CODENTIDADANTERIOR = ?, @ESTADO = ?, @FECHAULTESTADO = ?, @IDSEDE = ?, @IDPROVEEDOR = ?, @FNACIMIENTO = ?, @FECHAAFILSGSSS = ?, @ACT_ECONO = ?, @IDESCOLARIDAD = ?, @INDCOTIZANTE = ?, @ULTIMOANOAPROBADO = ?, @INCAPACIDADLABORAL = ?, @TIPODISCAPACIDAD = ?, @TIPOAFILIADO = ?, @GRUPOATESPECIAL = ?, @CABEZADEFAMILIA = ?, @ASOCIADO = ?, @TIENEOBS = ?, @CAMPOUSUARIO1 = ?, @FECHAUVISITA = ?, @CONSANGUINIDAD = ?, @IDADMINISTRADORA = ?, @IDCAUSAL = ?, @FECHACAUSAL = ?, @CLASIFPC = ?, @NIVELSOCIOEC = ?, @IDPLAN = ?, @FECHAAFILIACION = ?, @NUMCARNET = ?, @CIUDADDOC = ?, @IDEMPLEADOR = ?, @SEMANASCOT = ?, @CARNETIZADO = ?, @FECHACARNET = ?, @CONSCERTIFICADO = ?, @CIUDADNAC = ?, @IDOCUPACION = ?, @NACIONALIDAD = ?, @CELULAR = ?, @DIRECCIONLAB = ?, @TELEFONOLAB = ?, @CNSAFIAA = ?, @SISBENNUMFICHA = ?, @SISBENFECHAFICHA = ?, @SISBENPUNTAJE = ?, @SISBENNUCLEOFAM = ?, @SISBENGRUPOB = ?, @IDCONTRATO = ?, @IDBARRIO = ?, @CLASEAFILIACIONARS = ?, @FORMULARIO = ?, @EMAIL = ?, @NORADICACION = ?, @FECHARADICACION = ?, @IDTIPOAFILIACION = ?, @IDCLASEAFILIACION = ?, @V_FORMULARIO = ?, @SISBENNIVEL = ?, @CNSXCPA = ?, @FESTADO = ?, @OKBD = ?, @USUARIOBD = ?, @NACIMIENTO = ?, @ITFC = ?, @CNSITFC = ?, @TIPOSUBSIDIO = ?, @COBERTURA_SALUD = ?, @TIPOAFILIADO2 = ?, @IDAFI_TITULAR = ?, @ES_NN = ?, @IDESPECIAL = ?, @MTRIAGE = ?, @FTRIAGE = ?, @GRUPOPOB = ?, @IDSEDETRIAGE = ?, @F_ACTUALIZA = ?, @PRIORIDAD = ?";
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
            // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            //     $data[] = $row;
            // }

            return $this->response;
        }
        catch(Exception $e)
        {
          $this->response->setResponse(false, $e->getMessage());
                return $this->response;
        }
    }

    
}