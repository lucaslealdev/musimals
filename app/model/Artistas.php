<?php
namespace musimals\model;

class Artistas{

	static function busca($palavrachave,$limit = 9){
		$limit = intval($limit);
		$app = \Slim\Slim::getInstance();
		return $app->database->query(
			"SELECT
				id,
				nome,
				caminho,
				plays,
				(select count(*) from musica where musica.artista=artista.id) as 'musicas'
			FROM artista
			WHERE
			nome LIKE :nome
			ORDER BY plays desc, nome asc
			LIMIT $limit",
			array(
				":nome" => '%'.str_replace(' ','%',$palavrachave).'%'
			)
		)->fetchAll();
	}
	static function get($id){
		$app = \Slim\Slim::getInstance();
		$arreio = $app->database->query(
			"SELECT
				id,
				nome,
				caminho,
				plays,
				(select count(*) from musica where musica.artista=artista.id) as 'musicas'
			FROM artista
			WHERE
			id = :codigo
			LIMIT 1",
			array(
				":codigo" => $id
			)
		)->fetchAll();
		if (!empty($arreio)) $arreio = $arreio[0];
		return $arreio;
	}
}