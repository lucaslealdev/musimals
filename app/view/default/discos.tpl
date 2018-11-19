<?php
$title = 'Discos';
include('includes/header.tpl');
include('includes/topbar.tpl');
include('includes/player.tpl');
$current = RAIZ.'/discos';
include('includes/menu.tpl');
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= RAIZ?>">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Discos</li>
  </ol>
</nav>
<?php if(!empty($discos)){?>
<h4>Discos</h4>
	<?php foreach($discos as $disco){extract($disco);?><a class="ajax" href="<?= RAIZ?>/discos/<?= $id?>/<?= urlencode($nomeartista.' '.$nome)?>"><img src="<?= $caminho?>/disco.png" style="width:100px;height:100px;margin:0px;"></a><?php }?>
<?php }?>
<?php include('includes/footer.tpl');