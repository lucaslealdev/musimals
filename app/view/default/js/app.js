window.fila = [];
window.indice = -1;

function loading(){
	$('body').append("<div id='loading'></div>");
}function stopLoading(){
	$('#loading').remove();
}

if(window.location.hash!==""){ /*remove hash inicial*/
	location.href=location.pathname;
}

function toggleHash($hash){
	if (window.location.hash!==$hash){
		window.location.hash=$hash;
	}else{
		history.back();
	}
}

$(window).on('hashchange',function(){
	if (window.location.hash=='#playlist'){
		$('#playlist').addClass('open');
	}else{
		$('#playlist').removeClass('open');
	}
});

function atualizaFila(){
	var origin = $('#plsauce tr').html();
	var linha = '';
	var tabela = $('#pl tbody');
	var classe="";
	tabela.html('');
	$(fila).each(function($i){
		classe = "";
		linha = origin.replace('{titulo}',this.nome).replace('{artista}',this.nomeartista).replace('{img}',this.capa);
		if (window.indice==$i) classe="playing";
		tabela.append('<tr class="item '+classe+'" data-indice="'+$i+'">'+linha+'</tr>');
	});
}

function array_move(arr, old_index, new_index) {
    if (new_index >= arr.length) {
        var k = new_index - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    return arr; // for testing
};

if ('mediaSession' in navigator) {
  navigator.mediaSession.setActionHandler('play', function() {$('.controle.play').click();});
  navigator.mediaSession.setActionHandler('pause', function() {$('.controle.pause').click();});
  navigator.mediaSession.setActionHandler('previoustrack', function() {$('.controle.anterior').click();});
  navigator.mediaSession.setActionHandler('nexttrack', function() {$('.controle.proxima').click();});
}

$(document).bind('keydown', 'space', function(e){
	e.preventDefault ? e.preventDefault() : e.returnValue = false;
	$('.controle.middle').click();
	return false;
});
$(document).bind('keydown', 'd', function(e){
	e.preventDefault ? e.preventDefault() : e.returnValue = false;
	$('.controle.proxima').click();
	return false;
});
$(document).bind('keydown', 'a', function(e){
	e.preventDefault ? e.preventDefault() : e.returnValue = false;
	$('.controle.anterior').click();
	return false;
});
$(document).bind('keydown', '+', function(e){
	e.preventDefault ? e.preventDefault() : e.returnValue = false;
	$('#volume').val(parseFloat($('#volume').val())+0.05).trigger('input');
	return false;
});
$(document).bind('keydown', '-', function(e){
	e.preventDefault ? e.preventDefault() : e.returnValue = false;
	$('#volume').val(parseFloat($('#volume').val())-0.05).trigger('input');
	return false;
});

function toast($msg){
	$.toast({
		text: $msg,
		/*position: {
	        left: 10,
	        bottom: 110
    	}*/
    });
}

function gotoDisco($indice){
	setTimeout(function(){
		loadPage(window.raiz+"/discos/"+fila[$indice].disco+'/'+encodeURI(fila[$indice].nomeartista+' - '+fila[$indice].nomedisco));
	},150);
}

function gotoArtista($indice){
	setTimeout(function(){
		loadPage(window.raiz+"/artistas/"+fila[$indice].artista+'/'+encodeURI(fila[$indice].nomeartista));
	},150);
}

function remFila($indice){
	window.fila.splice($indice,1);
	atualizaFila();
	if (window.indice==$indice){
		playMusica($indice);
	}
}

function addFila($obj){
	var isArray = Array.isArray($obj);
	var plural = '';
	var antes = fila.length;
	if (!isArray){
		fila.push({
			'caminho':$obj.caminho,
			'artista':$obj.artista,
			'capa':$obj.capa,
			'duracao':$obj.duracao,
			'id':$obj.id,
			'nome':$obj.nome,
			'nomeartista':$obj.nomeartista,
			'nomedisco':$obj.nomedisco
		});
	}else {
		plural = 's';
		fila = fila.concat($obj);
	}

	atualizaFila();

	if (antes===0){
		playMusica(0);
		return;
	}else{
		toast('Música'+plural+' adicionada'+plural+' à fila');
	}
}
function addProxima($obj){
	fila.splice(window.indice+1, 0, $obj);
	atualizaFila();
	if (fila.length===1){
		playMusica(0);
		return;
	}else{
		toast('Música adicionada à fila');
	}
}
function addNow($obj){
	fila.splice(window.indice+1, 0, $obj);
	atualizaFila();
	if (fila.length===1){
		playMusica(0);
		return;
	}else{
		playMusica(window.indice+1);
	}
}

function setFila($filastr){
	if (typeof $filastr=='string'){
		$filastr = JSON.parse($filastr);
	}
	fila = $filastr;
	atualizaFila();
	playMusica(0);
}

function addDiscoPlay($id){
	$.ajax({
		method: "GET",
		url: window.raiz+"/discos/addplay/"+$id
	});
}

function playMusica($indice){
	if (typeof $indice==='undefined') $indice = 0;
	window.indice = $indice;
	var audio = document.getElementById('player');
	audio.src=fila[$indice].caminho;
	audio.load();
	audio.play();

	$('#pl .playing').removeClass('playing');
	$('#pl tr[data-indice="'+$indice+'"]').addClass('playing');

	$.ajax({
		method: "GET",
		url: window.raiz+"/musicas/addplay/"+fila[$indice].id
	});
	if ('mediaSession' in navigator) {
		if (navigator.mediaSession.metadata===null){
			navigator.mediaSession.metadata = new MediaMetadata({
				title: fila[$indice].nome,
				artist: fila[$indice].nomeartista,
				album: fila[$indice].nomedisco,
				artwork: [
					{ src: fila[$indice].capa, sizes: '512x512', type: 'image/png' },
				]
			});
		}else{
			navigator.mediaSession.metadata.title = fila[$indice].nome;
			navigator.mediaSession.metadata.artist = fila[$indice].nomeartista;
			navigator.mediaSession.metadata.album = fila[$indice].nomedisco;
			navigator.mediaSession.metadata.artwork = [
				{ src: fila[$indice].capa, sizes: '512x512', type: 'image/png' },
			];
		}
	}
	$('#player-wrapper .capinha').css('background-image','url("'+fila[$indice].capa+'")');
	var musica = $('#musica');
	clearInterval(window.spinnertimer);
	musica.text(fila[$indice].nome+' ('+fila[$indice].nomeartista+') ');
	if(hasEllipsis(musica)){
		spinning(musica);
	}else{
		spinning(musica,'destroy');
		musica.text(fila[$indice].nome+' ('+fila[$indice].nomeartista+') ');
	}
}
$(document).ready(function(){
	$('body').attr('data-pathname',location.pathname);
});
function loadPage($url,$pushstate = true){
	if ((!$pushstate && $url == $('body').attr('data-pathname')) || ($pushstate && $url==$('body').attr('data-pathname'))){
		return false;
	}
	$('body').attr('data-pathname',$url);
	if (typeof window.pageLoading!=='undefined') window.pageLoading.abort();
	$('#main').addClass('loading');
	window.pageLoading = $.ajax({
	  method: "GET",
	  url: $url
	})
	.done(function(response) {
		if($("<div>"+response+"</div>").find('title').length>0){
			document.title = $("<div>"+response+"</div>").find('title').text();
		}
		if($("<div>"+response+"</div>").find('#main').length>0){
			response = $("<div>"+response+"</div>").find('#main').html();
		}
		$('#main').html(response);
		if ($pushstate) history.pushState(null, null, $url);
	})
	.fail(function(response) {
		if (response.statusText =='abort') {
	        return;
	    }
		var simulate = $("<div>"+response.responseText+"</div>");
		if($(simulate).find('#main').length>0){
			response.responseText = $(simulate).find('#main').html();
		}
		$('#main').html(response.responseText);
	})
	.always(function() {
		window.scrollTo(0, 0);
		$('#main').removeClass('loading');
	});
}

$(document).ready(function(){
	$('#main').on('click mousedown','a.ajax[href], ol.breadcrumb a',function(e){
		if (e.which==1){
			e.preventDefault ? e.preventDefault() : e.returnValue = false;
			loadPage($(this).attr('href'));
			return false;
		}
	})
});

window.addEventListener("popstate", function(e) {
	loadPage(location.pathname,false);
});

function hscrollAdjust(){
	$('.hscroll').wrap('<div class="extra-wrapper"></div>');
	$('.extra-wrapper').append('<div class="right"></div>').append('<div class="left"></div>');

	$('.extra-wrapper > .right').on('click',function(){
		var pixels = $(this).parent().width()/2;
		$elem = $(this).parent().find('.hscroll');
		$elem.stop().animate({scrollLeft:$elem.scrollLeft()+pixels}, 300, 'swing');
	});
	$('.extra-wrapper > .left').on('click',function(){
		var pixels = $(this).parent().width()/2;
		$elem = $(this).parent().find('.hscroll');
		$elem.stop().animate({scrollLeft:$elem.scrollLeft()-pixels}, 300, 'swing');
	});
	$(window).off('resize');
	$(window).on('resize',function(){
		if ($('.hscroll').length==0){
			$(window).off('resize');
			return;
		}
		$('.hscroll').each(function(){
			var t = {real:$(this)[0].scrollWidth,porfora:$(this).innerWidth()};

			if (t.real>t.porfora){
				$(this).addClass('slider');
			}else{
				$(this).removeClass('slider');
			}
			$(this).scroll();
		});
	}).trigger('resize');

	$('.hscroll').off('scroll');
	$('.hscroll').on('scroll',function(){
		var posicao = isEnded($(this));
		if (posicao===false){
			$(this).addClass('left').addClass('right');
		}else if(posicao=='right'){
			$(this).addClass('left').removeClass('right');
		}else if(posicao=='left'){
			$(this).removeClass('left').addClass('right');
		}
	}).scroll();
}

function isEnded(elem){
	if(elem.scrollLeft() + elem.width() == elem[0].scrollWidth) {
		return 'right';
	}else if(elem.scrollLeft()===0){
		return 'left';
	}else{
		return false;
	}
}

function hasEllipsis($element){
	var $c = $element
	           .clone()
	           .css({display: 'inline', width: 'auto', visibility: 'visible'})
	           .appendTo('body');
	if( ($c.width()-10) > $element.width() ) {
		$c.remove();
	    return true;
	}
	$c.remove();
    return false;
}

function spinning(elem,acao){
	if (typeof acao==='undefined') acao='';

	if (acao=='destroy'){
		if (typeof window.spinnertimer !== 'undefined'){
			clearInterval(window.spinnertimer);
		}
		return;
	}
	clearInterval(window.spinnertimer);
	window.spinnertimer = setInterval(function(){
		var str = elem.text();
		str = str.substr(1) + str.substr(0, 1);
		elem.text(str);
	},150);

}

$(document).on('mousedown','.btn-group',function(){
	var menu = $(this).find('.dropdown-menu');
	$(this).removeClass('dropup');
	if(
		($(this).offset().top - $(window).scrollTop()) /*posicao do botao*/
		> ($(window).height()/2)
	){
		$(this).addClass('dropup');
	}
});