<?php
use App\Model\TgenModel;
use App\Lib\Response;
$app->group('/tgen/', function () {
    // $this->get('[{tabla}]/[{campo}]/[{codigo}]', function ($req, $res, $args) {
    $this->get('{tabla}/{campo}/[{codigo}]', function ($req, $res, $args) {
        $campo="";
        $tabla="";
        $codigo="";
        if(isset($args["tabla"])){ $tabla =  $args["tabla"]; }
        if(isset($args["campo"])){ $campo =  $args["campo"]; }
        if(isset($args["codigo"])){ $codigo =  $args["codigo"]; }
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new TgenModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
        // return $res->getBody()
        //            ->write("Tabla Generica");

        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $model->Get($tabla,$campo,$codigo)
            )
        );
    });
});