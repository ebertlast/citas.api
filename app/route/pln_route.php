<?php
use App\Model\PlnModel;
use App\Lib\Response;
$app->group('/pln/', function () {
    $this->get('[{idtercero}]', function ($req, $res, $args) {
        $idtercero="";
        if(isset($args["idtercero"])){ $idtercero =  $args["idtercero"]; }
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new PlnModel($dbhost, $dbname, $dbuser, $dbpasswd);
        }catch(Exception $e){
            $response = new Response();
            $response -> SetResponse (false, $e->getMessage());
            return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $response
                )
            );
        }

        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $model->Get($idtercero)
            )
        );
    });
});