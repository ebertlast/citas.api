<?php
use App\Model\MedModel;
use App\Lib\Response;
$app->group('/med/', function () {
    $this->get('{idemedica}', function ($req, $res, $args) {
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new MedModel($dbhost, $dbname, $dbuser, $dbpasswd);
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

        // $idmedico="";
        $idemedica="";
        // if(isset($args["idmedico"])){ $idmedico =  $args["idmedico"]; }
        if(isset($args["idemedica"])){ $idemedica =  $args["idemedica"]; }
        $response = $model->Get('',$idemedica);
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