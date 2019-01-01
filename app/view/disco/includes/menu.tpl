<label id="menucontrol" tabindex="2">
	<label id="shadow" for="menuclose"></label>
	<div id="menu">
		<label id="menucontrol2" for="menuclose"></label>
		<div id="logo"></div>
		<ul>
			<li><a href="<?= RAIZ?>" class="ajax"><i class="fa fa-fw fa-home"></i> Home</a></li>
			<li><a href="<?= RAIZ?>/artistas" class="ajax"><i class="fa fa-fw fa-users"></i> Artistas</a></li>
			<li><a href="<?= RAIZ?>/discos" class="ajax"><i class="fa fa-fw fa-dot-circle-o"></i> Discos</a></li>
			<li><a href="<?= RAIZ?>/sistema/scan" ><i class="fa fa-fw fa-refresh"></i> Atualizar biblioteca</a></li>
		</ul>
	</div>
</label>
<input type="checkbox" name="menuclose" id="menuclose" tabindex="1">
<script type="text/javascript">
	$('#menucontrol a.ajax').click(function(e){
		e.preventDefault();
		loadPage($(this).attr('href'));
	});
</script>
<main id="main" role="main" class="container-fluid">
<div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>