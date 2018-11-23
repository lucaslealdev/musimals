<?php
$title = 'Busca';
include('includes/header.tpl');
include('includes/topbar.tpl');
include('includes/player.tpl');
$current = RAIZ;
include('includes/menu.tpl');
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= RAIZ?>">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Buscando por "<?= htmlentities($busca)?>"</li>
  </ol>
</nav>

<?php if(!empty($discos)){?>
<h4>Discos</h4>
	<?php foreach($discos as $disco){extract($disco);?>
		<a class="ajax col-xs-6 col-sm-3 col-md-3 col-lg-2 col-xl-1m" href="<?= RAIZ?>/discos/<?= $id?>/<?= urlencode($nomeartista.' '.$nome)?>">
			<div class="grd disco">
				<div class="img" style="background-image:url('<?= addslashes($caminho)?>/disco.png');"></div>
				<p><span><?= $nome?></span> (<?= $musicas?>)</p>
			</div>
		</a>
	<?php }?>
<?php }?>


<?php include('includes/footer.tpl');