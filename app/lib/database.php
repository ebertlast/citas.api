<?php
namespace App\Lib;
// use PDO;
use Exception;
class Database
{
    public static function StartUpDEPRECATED($dbhost = "VAIO", $dbname = "KRYESTRIOS", $dbuser = "sa", $dbpass = "123456") {
        try {
            $strConex = "odbc:Driver={SQL Server Native Client 11.0};Server=$dbhost;Database=$dbname; Uid=$dbuser;Pwd=$dbpass";
            if($dbuser === ""){ $strConex = "odbc:Driver={SQL Server Native Client 11.0};Server=$dbhost;Database=$dbname; Trusted_Connection=Yes;"; }
            $options = array("CharacterSet" => "UTF-8");
            $dbh = new PDO($strConex);
            // $dbh = new PDO("Driver={SQL Server Native Client 10.0};Server=$server;Database=$database;", $user, $password);
            // $dbh = new PDO ("odbc:host=".$dbhost.";dbname=".$dbname, $dbuser, $dbpass);
            // conn.ConnectionString = "Data Source=" + SERVER + ";Initial Catalog=" + DB + ";Integrated Security=false;UID=sa;PWD=SGPserver01*;";
            // $dbh = new PDO("odbc:Driver={SQL Server Native Client 11.0};Server=$dbhost;Database=$dbname; IntegratedSecurity=true");
            // $dbh -> exec("SET NAMES 'utf8';");
            $pdo = $dbh;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        // $pdo->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
        return $pdo;
    }
    public static function StartUp($dbhost = "VAIO", $dbname = "KRYESTRIOS", $dbuser = "", $dbpass = "") {
        try {
            $serverName = $dbhost; 
            $connectionInfo = ($dbuser === "") ? 
                array( "Database"=>$dbname, "CharacterSet" => "UTF-8") : 
                array( "Database"=>$dbname, "UID"=>$dbuser, "PWD"=>$dbpass, "CharacterSet" => "UTF-8");
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            if( $conn ) {
                return $conn;
           }else{
                // throw new Exception("Conexión no se pudo establecer. ".print_r( sqlsrv_errors(), true), 1);
                // var_dump( sqlsrv_errors());
                $msgError="Error al establecer conexión";
                foreach (sqlsrv_errors()as $error) {
                    $msgError=$msgError."; (".$error['code'].") ".$error["message"];
                    // var_dump($error['message']);
                }
                throw new Exception($msgError, 1);
                
                // die( print_r( sqlsrv_errors(), true));
           }
        } catch(Exception $e) {
            // echo '{"error":{"text":'. $e->getMessage() .'}}';
            throw new Exception( $e);
            // return $e;
        }
        return $conn;
    }
}
