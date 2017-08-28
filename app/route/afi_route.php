<?php
use App\Model\AfiModel;
use App\Lib\Response;
use App\Lib\Correo;


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
        $response = $model->Post($data['afiliado']);
        $email = $data['afiliado']['EMAIL'];
        $razonsocial = $data['afiliado']['PNOMBRE'].' '.$data['afiliado']['PAPELLIDO'];
        if($response->result === true && $email!=""){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = $conf['mailer']['host'];
            $mail->SMTPAuth = true;
            $mail->IsHTML(true);
            $mail->Username = $conf['mailer']['username'];
            $mail->Password = $conf['mailer']['password'];
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            // $mail->From = "ebertunerg@gmail.com";
            $mail->setFrom($conf['mailer']['username'], 'Citas Médicas Krystalos');
            $mail->AddAddress($email, $razonsocial);
            $mail->Subject = "Afiliación a Krystalos";
            $mail->Body = "Bienvenido a Krystalos, usted ha sido afiliado satisfactoriamente y debe ahora registrarse para configurar su usuario.";
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
});