<?php
use App\Model\UsusuwModel;
use App\Lib\Response;
$app->group('/ususuw/', function () {
    $this->get('[{usuario}]', function ($req, $res, $args) {
        $usuario="";
        if(isset($args["usuario"])){
         $usuario =  $args["usuario"];
        }
        try{
            //   $um = new UsusuModel($servidor,$dbbase,$usuario,$clave);
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            // $dbpasswd="enclave";
            $um = new UsusuwModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
        //            ->write("Hello Users.- {$usuario}");

        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->Get($usuario)
            )
        );
    });

    $this->put('', function($req, $res, $args){
        $json = $req->getParsedBody();
        $data = json_decode($json['json'],true);
        $usuario = $data['usuario'];
        try{
            //   $um = new UsusuModel($servidor,$dbbase,$usuario,$clave);
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            // $dbpasswd="enclave";
            $um = new UsusuwModel($dbhost, $dbname, $dbuser, $dbpasswd);
        }catch(Exception $e){
            $response = new Response();
            $response -> SetResponse (false, 'Imposible establecer conexión.');
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
                $um->Put($usuario)
            )
        );
    });

    $this->post('autenticar', function($req, $res, $args) {
        return $res ->getBody()
                    ->write('Autenticar');
    });
});