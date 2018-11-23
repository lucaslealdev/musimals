<?php
$title = 'Artistas';
include('includes/header.tpl');
include('includes/topbar.tpl');
include('includes/player.tpl');
$current = RAIZ.'/artistas';
include('includes/menu.tpl');
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= RAIZ?>">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Artistas</li>
  </ol>
</nav>
<?php if(!empty($artistas)){?>
<h4>Artistas</h4>
	<?php foreach($artistas as $art){extract($art);?>
		<a class="ajax col-xs-6 col-sm-3 col-md-3 col-lg-2 col-xl-1m" href="<?= RAIZ?>/artistas/<?= $id?>/<?= urlencode($nome)?>">
			<div class="grd artista">
				<div class="img" style="background-image:url('<?= addslashes($caminho)?>/artista.png');"></div>
				<p><span><?= $nome?></span> (<?= $musicas?>)</p>
			</div>
		</a>
	<?php }?>
<?php }?>
<?php include('includes/footer.tpl');