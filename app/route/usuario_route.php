<?php

$app->group('/usuarios/', function () {
    
    $this->get('', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('Hello Users');
    });
    
});