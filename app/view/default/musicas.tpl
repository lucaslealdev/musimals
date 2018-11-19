<?php
$title = $dados['nome'].' ('.$dados['nomeartista'].')';
include('includes/header.tpl');
include('includes/topbar.tpl');
include('includes/player.tpl');
$current = RAIZ;
include('includes/menu.tpl');
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= RAIZ?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= RAIZ?>/artistas/<?= $dados['artista']?>/<?= urlencode($dados['nomeartista'])?>"><?= $dados['nomeartista']?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $dados['nome']?></li>
  </ol>
</nav>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
		<img src="<?= $dados['caminho']?>/disco.png" style="width:100%;">
	</div>
	<div class="col-xs-12 col-md-8 col-sm-8 col-lg-10 dados-disco">
		<h3><?= $dados['nome']?></h3>
		<a class="ajax" href="<?= RAIZ?>/artistas/<?= $dados['artista']?>/<?= urlencode($dados['nomeartista'])?>"><?= $dados['nomeartista']?></a>
		| <span><?= $dados['musicas']?> músicas</span> <button type="button" class="btn btn-xs btn-info" onclick="setFila($('#tbl_musicas').data('musicas'));addDiscoPlay(<?= $dados['id']?>);">TOCAR TUDO</button>
		<button type="button" class="btn btn-xs btn-default" onclick="addFila($('#tbl_musicas').data('musicas'));addDiscoPlay(<?= $dados['id']?>);">ADICIONAR À FILA</button>
	</div>
	<div class="col-xs-12">
		<div class="table-music-wrapper">
			<table class="table table-hover table-music" id="tbl_musicas">
				<thead>
					<tr>
						<th class="hidden-xs">N°</th>
						<th></th>
						<th>NOME</th>
						<th class="hidden-vxs"><i class="fa fa-clock-o" title="Duração"></i></th>
						<th class="hidden-xs"><i class="fa fa-play" title="Reproduções"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($musicas as $key=>$musica){extract($musica);?>
					<tr>
						<td class="hidden-xs"><?= $key+1?></td>
						<td>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<ul class="dropdown-menu">
									<li onclick="addFila($('#tbl_musicas').data('musicas')[<?= $key?>]);">Adicionar à fila</li>
									<li onclick="addProxima($('#tbl_musicas').data('musicas')[<?= $key?>]);">Reproduzir a seguir</li>
									<li onclick="addNow($('#tbl_musicas').data('musicas')[<?= $key?>]);">Reproduzir agora</li>
								</ul>
							</div>
						</td>
						<td onclick="addFila($('#tbl_musicas').data('musicas')[<?= $key?>]);"><?= $nome?></td>
						<td class="hidden-vxs"><?= $duracao?></td>
						<td class="hidden-xs"><?= $plays?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<script type="text/javascript">
				(function(){
					var marray = <?= json_encode($musicas)?>;
					$('#tbl_musicas').data('musicas',marray);
				})();
			</script>
		</div>
	</div>
</div>
<?php include('includes/footer.tpl');