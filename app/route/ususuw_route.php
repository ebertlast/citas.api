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
    $this->get('activar/{usuario}/{key}', function ($req, $res, $args) {
        $usuario="";
        $key="";
        if(isset($args["usuario"])){ $usuario =  $args["usuario"];}
        if(isset($args["key"])){ $key =  $args["key"];}
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
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
        
        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->Activar($usuario, $key)
            )
        );
    });
    $this->get('{idafiliado}/{tipo_doc}', function ($req, $res, $args) {
        $idafiliado="";
        $tipo_doc="";
        if(isset($args["idafiliado"])){ $idafiliado =  $args["idafiliado"]; }
        if(isset($args["tipo_doc"])){ $tipo_doc =  $args["tipo_doc"]; }
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
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
                $um->GetByDocumento($idafiliado, $tipo_doc)
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

    // Nuevo Usuario
    $this->post('', function ($req, $res, $args) {
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new UsusuwModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
        
        $response = $model->Put($data['usuario']);
        $email = $data['usuario']['EMAIL'];
        $usuario = $response->result[0];
        if($response->result){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = $conf['mailer']['host'];
            $mail->SMTPAuth = true;
            $mail->IsHTML(true);
            $mail->Username = $conf['mailer']['username'];
            $mail->Password = $conf['mailer']['password'];
            $mail->SMTPSecure = "ssl";
            $mail->Port = $conf['mailer']['port'];
            // $mail->From = "ebertunerg@gmail.com";
            $mail->setFrom($conf['mailer']['username'], 'Citas Médicas Krystalos');
            $mail->AddAddress($email, $email);
            $mail->Subject = "Registro para acceder a Krystalos WEB";
            $body = "Bienvenido a Krystalos, usted ha sido registrado satisfactoriamente y su contraseña para acceder al sistema es: <b>".$data['usuario']['CLAVE']."</b>";
            $body .= "<br /><br />Pero antes debe usted activar su registro haciendo click en el siguiente link: ".$conf['mailer']['urlactivate'].'/'.$usuario['USUARIO'].'/'.$usuario['KEYACTIVATE'];
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';
            $mail->Send(); /*When this line runs then it it send the gmail and my api is called  and below mentioned response is never executed*/
        }
        
        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $response
            )
        );
    });

    // Reenviar correo para activar el usuario
    $this->post('reenviar/{usuario}', function ($req, $res, $args) {
        try{
            $conf = $this->get('settings');
            $dbhost = $conf['dabase_default']['dbhost'];  
            $dbname = $conf['dabase_default']['dbname'];  
            $dbuser = $conf['dabase_default']['dbuser'];  
            $dbpasswd = $conf['dabase_default']['dbpasswd'];  
            $model = new UsusuwModel($dbhost, $dbname, $dbuser, $dbpasswd);
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
        $usuario="";
        if(isset($args["usuario"])){$usuario =  $args["usuario"];}
        
        $response = $model->Get($usuario);
        
        $usuario = $response->result[0];
        $email = $usuario['EMAIL'];
        // var_dump($email);
        if($response->result){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = $conf['mailer']['host'];
            $mail->SMTPAuth = true;
            $mail->IsHTML(true);
            $mail->Username = $conf['mailer']['username'];
            $mail->Password = $conf['mailer']['password'];
            $mail->SMTPSecure = "ssl";
            $mail->Port = $conf['mailer']['port'];
            // $mail->From = "ebertunerg@gmail.com";
            $mail->setFrom($conf['mailer']['username'], 'Citas Médicas Krystalos');
            $mail->AddAddress($email, $email);
            $mail->Subject = "Reenvío de enlace para activar usuario de Krystalos WEB";
            $body = "Hola, para activar su registro debes hacer click en el siguiente link: ".$conf['mailer']['urlactivate'].'/'.$usuario['USUARIO'].'/'.$usuario['KEYACTIVATE'];
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';
            $mail->Send(); /*When this line runs then it it send the gmail and my api is called  and below mentioned response is never executed*/
        }
        
        $response->result=true;

        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $response
            )
        );
    });
    

    $this->get('autenticar/{usuario}/{clave}', function ($req, $res, $args) {
        $usuario="";
        $clave="";
        if(isset($args["usuario"])){$usuario =  $args["usuario"];}
        if(isset($args["clave"])){$clave =  $args["clave"];}
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
                $um->Autenticar($usuario, $clave)
            )
        );
    });
});