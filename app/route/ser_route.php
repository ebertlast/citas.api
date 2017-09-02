<?php
use App\Model\SerModel;
use App\Lib\Response;
$app->group('/ser/', function () {
    $this->get('{idafiliado}/{tipo_doc}/{idmedico}', function ($req, $res, $args) {
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new SerModel($dbhost, $dbname, $dbuser, $dbpasswd);
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

        $idafiliado="";
        $tipo_doc="";
        $idmedico="";
        if(isset($args["idafiliado"])){ $idafiliado =  $args["idafiliado"]; }
        if(isset($args["tipo_doc"])){ $tipo_doc =  $args["tipo_doc"]; }
        if(isset($args["idmedico"])){ $idmedico =  $args["idmedico"]; }
        $response = $model->Get($idafiliado,$tipo_doc,$idmedico);
        $response->setToken($req->getAttribute('token'));
        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $response
            )                
        );
    });
});