<div id="topbar">
	<main role="topbar" class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<form id="busca" method="GET">
					<input value="<?= (isset($busca)?$busca:'')?>" type="text" placeholder="Pesquisar" class="form-control" required>
				</form>
			</div>
		</div>
	</main>
</div>
<script type="text/javascript">
	$('form#busca').on('submit',function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var value = $('form#busca input[type=text]').val();
		loadPage(window.raiz+'/busca/'+encodeURI(value));
		return false;
	});
</script>