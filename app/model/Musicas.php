<?php
namespace musimals\model;

class Musicas{

	static function busca($palavrachave,$limit = 20){
		$limit = intval($limit);
		$app = \Slim\Slim::getInstance();
		return $app->database->query(
			"SELECT
				musica.id,
				musica.artista,
				musica.disco,
				musica.nome,
				musica.caminho,
				musica.plays,
				artista.nome as 'nomeartista',
				disco.nome as 'nomedisco'
			FROM musica
			inner join artista on artista.id=musica.artista
			inner join disco on disco.id=musica.disco
			WHERE
			musica.nome LIKE :nome
			ORDER BY musica.plays desc, musica.nome asc
			LIMIT $limit",
			array(
				":nome" => '%'.str_replace(' ','%',$palavrachave).'%'
			)
		)->fetchAll();
	}

	static function addPlay($id){
		$app = \Slim\Slim::getInstance();
		$disco = self::get($id);
		$app->database->query("UPDATE musica set plays=plays+1 where musica.id=:codigo;",array(':codigo'=>$id));
		$app->database->query("UPDATE artista set plays=plays+1 where artista.id=(select musica.artista from musica where musica.id=:codigo);",array(':codigo'=>$id));
	}

	static function lista($disco){
		$app = \Slim\Slim::getInstance();
		$musicas = $app->database->query(
			"SELECT
				musica.id,
				musica.artista,
				musica.disco,
				musica.nome,
				musica.caminho,
				musica.plays,
				artista.nome as 'nomeartista',
				disco.nome as 'nomedisco',
				disco.caminho||'/disco.png' as capa
			FROM musica
			inner join artista on artista.id=musica.artista
			inner join disco on disco.id=musica.disco
			WHERE
			musica.disco = :codigo
			ORDER BY musica.nome asc",
			array(
				":codigo" => intval($disco)
			)
		)->fetchAll();

		foreach($musicas as &$msc){
			$realpath = substr(str_replace(RAIZ, '', $msc['caminho']),1);
			$audio = new \wapmorgan\Mp3Info\Mp3Info(windows_utf8_decode($realpath));
			$min = floor($audio->duration / 60);
			$seg = floor($audio->duration % 60);
			$msc['duracao'] = (($min<10)?'0'.$min:$min).':'.(($seg<10)?'0'.$seg:$seg);
		}

		return $musicas;
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