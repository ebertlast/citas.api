<?php
use App\Model\TerModel;
use App\Lib\Response;
$app->group('/ter/', function () {
    $this->get('[{idcategoria}]', function ($req, $res, $args) {
        $idcategoria="";
        if(isset($args["idcategoria"])){ $idcategoria =  $args["idcategoria"]; }
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new TerModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
                $model->Get('',$idcategoria)
            )
        );
    });
});