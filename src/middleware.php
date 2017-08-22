<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
use App\Lib\Response;
use App\Lib\Tokens;
$app->add(function ($request, $response, $next) {
    // $response->getBody()->write('ANTES');

    // Obtenemos la ruta que esta intentando acceder el usuario
    // en el futuro se quiere validar los accesos a las rutas por usuario desde aquí
    $route = $request->getUri()->getPath();//RUTA ACTUAL A LA QUE INTENTA ACCEDER
	$route = explode("/",$route)[0];

    /*SECCIÓN DE TOKENS*/
    if($route != "autenticar" && $route != "companias"){
        $authorization = $request->getHeader("Authorization");
        $nuevoToken = "";

        $respuesta = new Response();
        $respuesta -> SetResponse(true);
        if(count($authorization)>0) {
            $token = explode(" ", $authorization[0])[1];
            // var_dump($token);
            $jwt = new Tokens();
            $data = array( );
            try{
                $data = $jwt->decode($token);
            }catch(Exception $e){
                $respuesta -> SetResponse (false, "Vuelve a iniciar sesión (". $e->getMessage() .").");
            }
            //var_dump($data);
            /*HACER AQUI LAS VALIDACIONES DE SEGURIDAD A LAS RUTAS POR USUARIO*/
            $nuevoToken = $jwt->encode($data);

        }else{
            if($route!="autenticar"){
                $respuesta -> SetLogout();
                $respuesta -> SetResponse (false, "Debe iniciar sesión.");
            }
        }
    }
    /*FIN DE LA SECCION DE TOKENS*/
    $response = $next($request, $response);

    // $response->getBody()->write('DESPUES');

    return $response;
});