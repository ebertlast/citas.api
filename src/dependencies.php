<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// var_dump($container);
// $container['mailer'] = function ($container) {
// 	$mailer = new PHPMailer;

// 	$mailer->Host = 'smtp.gmail.com';  // your email host, to test I use localhost and check emails using test mail server application (catches all  sent mails)
// 	$mailer->SMTPAuth = true;                 // I set false for localhost
// 	$mailer->SMTPSecure = 'ssl';              // set blank for localhost
// 	$mailer->Port = 465;                           // 25 for local host
// 	$mailer->Username = 'ebertunerg@gmail.com';    // I set sender email in my mailer call
// 	$mailer->Password = '123Enclave.21978';
// 	$mailer->isHTML(true);

// 	return new \App\Lib\Mailer($container->view, $mailer);
// };