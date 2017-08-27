<?php
use App\Model\AfiModel;
use App\Lib\Response;
$app->group('/afi/', function () {
    $this->get('{idafiliado}/[{tipoident}]', function ($req, $res, $args) {
        $idafiliado="";
        $tipoident="";
        if(isset($args["tipoident"])){ $tipoident =  $args["tipoident"]; }
        if(isset($args["idafiliado"])){ $idafiliado =  $args["idafiliado"]; }
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new AfiModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
                $model->Get($idafiliado,$tipoident)
            )
        );
    });

    $this->post('', function ($req, $res, $args) {
        
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new AfiModel($dbhost, $dbname, $dbuser, $dbpasswd);
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

        $json = $req->getParsedBody();
        

        $data = json_decode($json['json'],true);
        // $response = new Response();
        // $response -> SetResponse (false, json_encode($data['afiliado']));
        // return $res
        // ->withHeader('Content-type', 'application/json')
        // ->getBody()
        // ->write(
        //     json_encode(
        //         $response
        //     )
        // );
        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $model->Post($data['afiliado'])
            )
        );
    });
});