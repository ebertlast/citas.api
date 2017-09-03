<?php
use App\Model\CitModel;
use App\Lib\Response;
$app->group('/cit/', function () {
    $this->get('{fdesde}/{fhasta}/{idmedico}/[{libres}]', function ($req, $res, $args) {
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new CitModel($dbhost, $dbname, $dbuser, $dbpasswd);
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

        $fhasta="";
        $fdesde="";
        $libres="0";
        $idemedica="";
        if(isset($args["fdesde"])){ $fdesde =  $args["fdesde"]; }
        if(isset($args["fhasta"])){ $fhasta =  $args["fhasta"]; }
        if(isset($args["idemedica"])){ $idemedica =  $args["idemedica"]; }
        if(isset($args["libres"])){ $libres =  $args["libres"]; }
        // $fhasta="1/4/2017";
        // $fdesde="1/4/2017";
        $fdesde=(date("d-m-Y", strtotime($fhasta)));
        $fhasta=(date("d-m-Y", strtotime($fhasta)));

        // $response = new Response();
        // $response -> SetResponse (false, $fdesde);
        // return $res
        // ->withHeader('Content-type', 'application/json')
        // ->getBody()
        // ->write(
        //     json_encode(
        //         $response
        //     )
        // );
        // var_dump($fdesde);
        // var_dump($fhasta);
        // var_dump($libres);
        
        $response = $model->Get($fdesde,$fhasta,$idemedica,$libres);
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

    $this->post('', function ($req, $res, $args) {
        
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new CitModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
        // $response -> SetResponse (false, $data['fdesde']);
        // return $res
        // ->withHeader('Content-type', 'application/json')
        // ->getBody()
        // ->write(
        //     json_encode(
        //         $response
        //     )
        // );


        $response = $model->Get($data['fdesde'], $data['fhasta'], $data['idmedico'], $data['libres']);
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

    // Nuevo Usuario
    $this->post('asignar', function ($req, $res, $args) {
        
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
        $response = $model->Post($data['cita']);
        
        
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