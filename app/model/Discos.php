<?php
namespace musimals\model;

class Discos{

	static function busca($palavrachave,$limit = 9){
		$limit = intval($limit);
		$app = \Slim\Slim::getInstance();
		return $app->database->query(
			"SELECT
				disco.id,
				disco.artista,
				disco.nome,
				disco.caminho,
				disco.plays,
				artista.nome as 'nomeartista',
				(select count(*) from musica where musica.disco=disco.id) as 'musicas'
			FROM disco
			inner join artista on artista.id=disco.artista
			WHERE
			disco.nome LIKE :nome
			ORDER BY disco.plays desc, disco.nome asc
			LIMIT $limit",
			array(
				":nome" => '%'.str_replace(' ','%',$palavrachave).'%'
			)
		)->fetchAll();
	}

	static function addPlay($id){
		$app = \Slim\Slim::getInstance();
		$disco = self::get($id);
		$app->database->query("UPDATE disco set plays=plays+1 where disco.id=:codigo;",array(':codigo'=>$id));
	}

	static function lista($artista){
		$app = \Slim\Slim::getInstance();
		return $app->database->query(
			"SELECT
				disco.id,
				disco.artista,
				disco.nome,
				disco.caminho,
				disco.plays,
				artista.nome as 'nomeartista',
				(select count(*) from musica where musica.disco=disco.id) as 'musicas'
			FROM disco
			inner join artista on artista.id=disco.artista
			WHERE
			artista = :codigo
			ORDER BY disco.plays desc, disco.nome asc",
			array(
				":codigo" => intval($artista)
			)
		)->fetchAll();
	}

	static function get($disco){
		$app = \Slim\Slim::getInstance();
		$arreio = $app->database->query(
			"SELECT
				disco.id,
				disco.artista,
				disco.nome,
				disco.caminho,
				disco.plays,
				artista.nome as 'nomeartista',
				(select count(*) from musica where musica.disco=disco.id) as 'musicas'
			FROM disco
			inner join artista on artista.id=disco.artista
			WHERE
			disco.id = :codigo
			ORDER BY disco.plays desc, disco.nome asc",
			array(
				":codigo" => intval($disco)
			)
		)->fetchAll();
		if (!empty($arreio)) $arreio = $arreio[0];
		return $arreio;
	}
}