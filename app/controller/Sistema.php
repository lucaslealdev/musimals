<?php
namespace musimals\controller;

class Sistema{
	static function startup(){
		$app = \Slim\Slim::getInstance();

		if (!file_exists('database.db')){
			$app->database->query("CREATE TABLE `artista` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, `nome` TEXT NOT NULL, `caminho` TEXT NOT NULL UNIQUE, `plays` INTEGER );");
			$app->database->query("CREATE TABLE `disco` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, `artista` INTEGER NOT NULL, `plays` INTEGER NOT NULL DEFAULT 0, `nome` TEXT NOT NULL, `caminho` TEXT NOT NULL UNIQUE, CONSTRAINT discoartistafk FOREIGN KEY(`artista`) REFERENCES `artista`(`id`) ON DELETE CASCADE );");
			$app->database->query("CREATE TABLE `musica` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, `artista` INTEGER NOT NULL, `disco` INTEGER NOT NULL, `nome` TEXT NOT NULL, `caminho` TEXT NOT NULL UNIQUE, `plays` INTEGER NOT NULL DEFAULT 0, CONSTRAINT musicadiscofk FOREIGN KEY(`disco`) REFERENCES `disco`(`id`) ON DELETE CASCADE, CONSTRAINT musicaartistafk FOREIGN KEY(`artista`) REFERENCES `artista`(`id`) ON DELETE CASCADE );");
			$app->database->query("CREATE INDEX `artistanome` ON `artista` ( `nome` ASC );");
			$app->database->query("CREATE INDEX `discoartista` ON `disco` ( `artista` ASC );");
			$app->database->query("CREATE INDEX `disconome` ON `disco` ( `nome` ASC );");
			$app->database->query("CREATE INDEX `musicadisco` ON `musica` ( `disco` ASC );");
			$app->database->query("CREATE INDEX `musicanome` ON `musica` ( `nome` ASC );");
			$app->database->query("CREATE INDEX `artplays` ON `artista` ( `plays` DESC );");
			$app->database->query("CREATE INDEX `discplays` ON `disco` ( `plays` DESC );");
			$app->database->query("CREATE INDEX `musicplays` ON `musica` ( `plays` DESC );");
			self::scan();
		}
	}

	static function scan(){
		$app = \Slim\Slim::getInstance();

		$arquivos = dirToArray(MUSICDIR);
		//echo '<pre>'; print_r($arquivos); echo '</pre>';
		$dom = new \PHPHtmlParser\Dom;

		$artistas_encontrados = array();
		$discos_encontrados=array();
		$musicas_encontradas = array();
		foreach($arquivos as $artista=>$discos){

			if(true /*sincroniza artistas*/){
				$targetArtista = MUSICDIR.$artista.DIRECTORY_SEPARATOR.'artista.png';
				//unlink($targetArtista);
				if (!file_exists($targetArtista)){
					$dom->loadFromUrl('http://www.google.com.br/search?as_st=y&tbm=isch&as_q=&as_epq='.urlencode(windows_utf8_encode($artista)).'&as_oq=&as_eq=&cr=&as_sitesearch=&safe=images&tbs=isz:m,iar:s');
					$image_container = $dom->find('table a > img', 0);
					file_put_contents($targetArtista, fopen($image_container->getAttribute('src'), 'r'));
				}
				$artista_id = $app->database->query(
					"SELECT id FROM artista WHERE nome = :nome;",
					array(
						":nome" => windows_utf8_encode($artista)
					)
				)->fetchAll();
				if (empty($artista_id)){
					$app->database->query(
						"INSERT into artista(nome,caminho,plays) VALUES(:nome,:caminho,0);",
						array(
							":nome" => windows_utf8_encode($artista),
							":caminho" => MUSIC.windows_utf8_encode($artista),
						)
					);
					$artista_id=intval($app->database->id());
				}else{
					$artista_id=intval($artista_id[0]['id']);
				}
				$artistas_encontrados[]=$artista_id;
			}

			foreach($discos as $disco=>$musicas){
				if(true /*sincroniza discos*/){
					$targetDisco = MUSICDIR.$artista.DIRECTORY_SEPARATOR.$disco.DIRECTORY_SEPARATOR.'disco.png';
					//unlink($targetDisco);
					if (!file_exists($targetDisco)){
						$googleRealURL = ('http://www.google.com.br/search?as_st=y&tbm=isch&as_q=&as_epq='.urlencode(windows_utf8_encode($artista).' '.windows_utf8_encode($disco)).'&as_oq=&as_eq=&cr=&as_sitesearch=&safe=images&tbs=isz:m,iar:s');

						// Call Google with CURL + User-Agent
						$ch = curl_init($googleRealURL);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
						curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux i686; rv:20.0) Gecko/20121230 Firefox/20.0');
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
						$google = curl_exec($ch);
						$array_imghtml = explode("\"ou\":\"", $google); //the big url is inside JSON snippet "ou":"big url"
						$array_imghtml_2 = array();
						$array_imgurl = array();
						foreach($array_imghtml as $key => $value){
						  if ($key > 0) {
						    $array_imghtml_2 = explode("\",\"", $value);
						    if (strpos($array_imghtml_2[0], "instagram")===false) $array_imgurl[] = $array_imghtml_2[0];
						  }
						}
						$chave = -1;
						while (isset($array_imgurl[$chave+1]) && !file_put_contents($targetDisco, fopen($array_imgurl[$chave+1], 'r'))){
							$chave++;
						}
					}
					$disco_id = $app->database->query(
						"SELECT id FROM disco WHERE nome = :disco and artista= :artista_id;",
						array(
							":disco" => windows_utf8_encode($disco),
							":artista_id" => $artista_id
						)
					)->fetchAll();
					if (empty($disco_id)){
						$app->database->query(
							"INSERT into disco(artista,nome,caminho,plays) VALUES(:arts,:nome,:caminho,0);",
							array(
								":arts"=> ($artista_id),
								":nome" => windows_utf8_encode($disco),
								":caminho" => MUSIC.windows_utf8_encode($artista).'/'.windows_utf8_encode($disco),
							)
						);
						$disco_id=intval($app->database->id());
					}else{
						$disco_id=intval($disco_id[0]['id']);
					}
					$discos_encontrados[]=$disco_id;
				}

				foreach($musicas as $musica){
					if(true /*sincroniza musicas*/){
						$musica_id = $app->database->query(
							"SELECT id FROM musica WHERE caminho = :caminhe and disco= :disquinho;",
							array(
								":caminhe" => MUSIC.windows_utf8_encode($artista).'/'.windows_utf8_encode($disco).'/'.windows_utf8_encode($musica),
								":disquinho" => $disco_id
							)
						)->fetchAll();
						if (empty($musica_id)){
							$nomem = windows_utf8_encode($musica);
							$nomem = substr($nomem, 0,-4);
							$nomem = trim(trim(trim(preg_replace('/((http:\/\/|https:\/\/)?\w+\.\w+.\w+)/m', '', $nomem)), '-'));
							$app->database->query(
								"INSERT into musica(artista,disco,nome,caminho,plays) VALUES(:art,:discx,:musicx,:caminhe,0);",
								array(
									":art"=> $artista_id,
									":discx"=> $disco_id,
									":musicx" => $nomem,
									":caminhe" => MUSIC.windows_utf8_encode($artista).'/'.windows_utf8_encode($disco).'/'.windows_utf8_encode($musica),
								)
							);
							$musica_id=intval($app->database->id());
						}else{
							$musica_id=intval($musica_id[0]['id']);
						}
						$musicas_encontradas[]=$musica_id;
					}
				}
			}
		}
		$app->database->query("DELETE FROM artista where id not in(".implode(',', $artistas_encontrados).");");
		$app->database->query("DELETE FROM disco where id not in(".implode(',', $discos_encontrados).");");
		$app->database->query("DELETE FROM musica where id not in(".implode(',', $musicas_encontradas).");");
	}

	public function __construct(){
		$app = \Slim\Slim::getInstance();
		$app->group('/sistema', function () use ($app) {
			$app->get('/startup',function () use ($app){
		    	if (file_exists('database.db')){
		    		unlink('database.db') or die('Não foi possível apagar');
		    	}
		    	\musimals\controller\Sistema::startup();
		    	$app->redirect(RAIZ);
		    });
		    $app->get('/scan',function () use ($app){
		    	\musimals\controller\Sistema::scan();
		    	$app->redirect(RAIZ);
		    });
		});
	}
}