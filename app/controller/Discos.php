<?php
namespace musimals\controller;

class Discos{
	public function __construct(){
		$app = \Slim\Slim::getInstance();
		$app->group('/discos', function () use ($app) {
			$app->get('/',function () use ($app){
				$discos = \musimals\model\Discos::busca('%',99999);
		    	$app->render(
		    		'discos.tpl',
		    		array(
		    			'discos'=>$discos
			    	)
		    	);
		    });

		    $app->get('/addplay/:id',function ($id) use ($app){
		    	\musimals\model\Discos::addPlay($id);
		    })->conditions(array('id' => '[0-9]+'));

		    $app->get('/:id(/:nomerecebido)',function ($id,$nomerecebido='') use ($app){
		    	$dados = \musimals\model\Discos::get($id);
		    	if (empty($dados)){
		    		$app->notFound();
		    	}
		    	$musicas = \musimals\model\Musicas::lista($id);
		    	$app->render(
		    		'musicas.tpl',
		    		array(
		    			'musicas'=>$musicas,
		    			'dados'=>$dados
			    	)
		    	);
		    })->conditions(array('id' => '[0-9]+'));
		});
	}
}