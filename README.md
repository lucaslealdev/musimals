# Musimals

Sistema para rede local de streaming privado de músicas em formato mp3 feito em PHP com banco de dados SQLite, e suporte a PWA em smartphones.

![](https://github.com/lucaasleaal/musimals/blob/master/screenshot.png)

Para fins de demonstração, este projeto inclui a canção Orbiting the Earth, de UltraCat, [disponível em Free Music Archive](http://freemusicarchive.org/music/UltraCat/Orbiting_the_Earth/ultracat_-_01_-_orbiting_the_earth) cujos créditos estão abaixo:

"CURATORS:

Oddio Overplay

Music for Video

RELEASED:July 14th, 2009

GENRES:

Electronic

House

LENGTH:00:14:47

LABEL:Cheshire Records

This 3-song single features a space-themed dancefloor-friendly house tune with kitschy 1950's samples, a disco-funk-tinged house banger and an intense, driving minimal piece, balancing out the release.

source: Cheshire Records"

## Funcionalidades

- Busca capas e imagens de artistas quando ausentes;
- Fila de reprodução interativa;
- Pesquisa por nome de artista ou disco;
- Banco de dados portátil sqlite;
- Interface mobile;
- Suporte à instalação PWA;


## Como usar

1 - Clone, ou baixe o repositório e descompacte-o.

2 - Instale o composer em seu computador se você já não o tiver (é fácil, eu prometo) e execute o comando "composer upgrade" dentro da pasta do Musimals. Este comando irá baixar as dependências do projeto.

3 - Altere o arquivo .htaccess para incluir o diretório utilizado em relação à raiz do servidor (RewriteBase).

4 - Altere o valor do start_url para incluir o diretório utilizado no arquivo app/view/default/manifest.json
