<?php
namespace musimals\controller;

class Busca{
	public function __construct(){
		$app = \Slim\Slim::getInstance();
		$app->group('/busca', function () use ($app) {
			$app->get('/artistas/:busca',function ($busca) use ($app){
				$artistas = \musimals\model\Artistas::busca($busca,999999);

		    	$app->render(
		    		'busca-artista.tpl',
		    		array(
		    			'artistas'=>$artistas,
		    			'busca'=>$busca
			    	)
		    	);
		    });
		    $app->get('/discos/:busca',function ($busca) use ($app){
				$discos = \musimals\model\Discos::busca($busca,999999);

		    	$app->render(
		    		'busca-disco.tpl',
		    		array(
		    			'discos'=>$discos,
		    			'busca'=>$busca
			    	)
		    	);
		    });
		    $app->get('/:busca',function ($busca) use ($app){
				$artistas = \musimals\model\Artistas::busca($busca);
				$discos = \musimals\model\Discos::busca($busca);

		    	$app->render(
		    		'busca-geral.tpl',
		    		array(
		    			'artistas'=>$artistas,
		    			'discos'=>$discos,
		    			'busca'=>$busca
			    	)
		    	);
		    });
		});
	}
}