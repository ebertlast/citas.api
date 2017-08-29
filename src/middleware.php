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
    // $route = ((explode("/",$route)[count(explode("/",$route))-1])==='') ? explode("/",$route)[0] :  explode("/",$route)[count(explode("/",$route))-1];
    $route = explode("/",$route)[0];
    // $route = $request->getUri()->getPath();
    // var_dump($route);
    $method = $request->getMethod();


    // $respuesta = new Response();
    // $respuesta -> SetLogout();
    // $respuesta -> SetResponse (false, $route);
    // return $response
    // ->withHeader('Content-type', 'application/json')
    // ->withJson(($respuesta))
    // ; 
    
    /*SECCIÓN DE TOKENS*/
    //!($route==="ususuw" && $method === "GET")
    if($route != "tgen" && $route != "afi" && $route != "ciub" && $route != "ocu"
        && $route != "ter" && $route != "pln" && $route !== "ususuw"
    ){
        $authorization = $request->getHeader("Authorization");
        // var_dump(count($authorization));
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

                return $response
                ->withHeader('Content-type', 'application/json')
                ->withJson(json_encode($respuesta))
                ; 
            }
            // var_dump($data);
            /*HACER AQUI LAS VALIDACIONES DE SEGURIDAD A LAS RUTAS POR USUARIO*/
            $nuevoToken = $jwt->encode($data);

        }else{
    
            $respuesta -> SetLogout();
            $respuesta -> SetResponse (false, "Debes iniciar sesión.");

            return $response
            ->withHeader('Content-type', 'application/json')
            ->withJson(($respuesta))
            // ->withJson(json_encode($respuesta))
            ; 
        }
    }
    /*FIN DE LA SECCION DE TOKENS*/
    $response = $next($request, $response);
    // $response = $next($request, $respuesta);
    
    // $response->getBody()->write('DESPUES');
    return $response;
});