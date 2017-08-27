<?php
use App\Model\CiubModel;
use App\Lib\Response;
$app->group('/ciub/', function () {
    $this->get('[{ciudadid}]', function ($req, $res, $args) {
        $ciudadid="";
        if(isset($args["ciudadid"])){ $ciudadid =  $args["ciudadid"]; }
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new CiubModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
                $model->Get($ciudadid)
            )
        );
    });
});