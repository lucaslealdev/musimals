<?php
$title = $dados['nome'];
include('includes/header.tpl');
include('includes/topbar.tpl');
include('includes/player.tpl');
$current = RAIZ.'/artistas';
include('includes/menu.tpl');
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= RAIZ?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= RAIZ?>/artistas">Artistas</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $dados['nome']?></li>
  </ol>
</nav>
<?php if(!empty($discos)){?>
<h4>Discos</h4>
	<div class="hscroll">
	<?php foreach($discos as $disco){extract($disco);?>
		<a class="ajax" href="<?= RAIZ?>/discos/<?= $id?>/<?= urlencode($nomeartista.' - '.$nome)?>">
			<div class="grd disco">
				<img src="<?= $caminho?>/disco.png">
				<p><span><?= $nome?></span> (<?= $musicas?>)</p>
			</div>
		</a>
	<?php }?>
	</div>
<?php }else{?>
<h4>Este artista não tem discos no banco de dados :(</h4>
<?php }?>
<script type="text/javascript">
	$(function() {
		hscrollAdjust();
	});
</script>

<?php include('includes/footer.tpl');