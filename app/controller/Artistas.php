<?php
namespace musimals\controller;

class Artistas{
	public function __construct(){
		$app = \Slim\Slim::getInstance();
		$app->group('/artistas', function () use ($app) {
			$app->get('/',function () use ($app){
				$artistas = \musimals\model\Artistas::busca('%',99999);
		    	$app->render(
		    		'artistas.tpl',
		    		array(
		    			'artistas'=>$artistas
			    	)
		    	);
		    });

		    $app->get('/:id(/:nomerecebido)',function ($id,$nomerecebido='') use ($app){
		    	$dados = \musimals\model\Artistas::get($id);
		    	if (empty($dados)){
		    		$app->notFound();
		    	}
		    	$discos = \musimals\model\Discos::lista($id);
		    	$app->render(
		    		'artista.tpl',
		    		array(
		    			'discos'=>$discos,
		    			'dados'=>$dados
			    	)
		    	);
		    })->conditions(array('id' => '[0-9]+'));
		});
	}
}