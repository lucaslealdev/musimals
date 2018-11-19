<?php
namespace musimals\controller;

class Home{
	public function __construct(){
		$app = \Slim\Slim::getInstance();
		$app->get('/',function () use ($app){
			$artistas = \musimals\model\Artistas::busca('%');
			$discos = \musimals\model\Discos::busca('%');
	    	$app->render(
			    'index.tpl',
			    array(
			    	'artistas'=>$artistas,
			    	'discos'=>$discos,
			    )
			);
	    });
	}
}