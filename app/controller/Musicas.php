<?php
namespace musimals\controller;

class Musicas{
	public function __construct(){
		$app = \Slim\Slim::getInstance();
		$app->group('/musicas', function () use ($app) {

		    $app->get('/addplay/:id',function ($id) use ($app){
		    	\musimals\model\Musicas::addPlay($id);
		    })->conditions(array('id' => '[0-9]+'));
		});
	}
}