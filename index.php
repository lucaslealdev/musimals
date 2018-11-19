<?php
require_once('app/config.php');
require 'vendor/autoload.php';

$app = new \Slim\Slim(array('templates.path' => './app/view/'.TEMA.'/','debug' => true));

//Get request object
$real = $app->request->getRootUri();
$real = str_replace('/index.php', '', $real);
define('RAIZ', $real);
define('VIEW', RAIZ . '/app/view/' . TEMA .'/');
$url = $app->request->getResourceUri();
define('ATUAL',$url);
define('MUSICDIR',__DIR__.DIRECTORY_SEPARATOR.'musicas'.DIRECTORY_SEPARATOR);
define('MUSIC',RAIZ.'/musicas/');


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	header('Content-Type: application/json');
	define("AJAX",true);
}else{
	define("AJAX",false);
}

$app->setName('Musimals');

$app->container->singleton('database', function () {
    return new \Medoo\Medoo([
		'database_type' => 'sqlite',
		'database_file' => 'database.db'
	]);
});

\musimals\controller\Sistema::startup();

$controle = explode('/',$app->request()->getResourceUri());

if (is_array($controle) && count($controle)>1){
	$controle = $controle[1];
	if (is_string($controle)){
		$controle = preg_replace('/[^a-z]/i', '', $controle);
		$controle = ucfirst($controle);
		if ($controle==''){
			$controle = 'Home';
		}
		$controle = "\musimals\\controller\\".$controle;
    	if (class_exists($controle)){
    		$controle = new $controle;
    	}
    }
}

$app->notFound(function () use ($app) {
    $app->render('404.tpl');
});

$app->run();