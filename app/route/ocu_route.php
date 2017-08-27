<?php
use App\Model\OcuModel;
use App\Lib\Response;
$app->group('/ocu/', function () {
    $this->get('[{ocupacionid}]', function ($req, $res, $args) {
        $ocupacionid="";
        if(isset($args["ocupacionid"])){ $ocupacionid =  $args["ocupacionid"]; }
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new OcuModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
                $model->Get($ocupacionid)
            )
        );
    });
});