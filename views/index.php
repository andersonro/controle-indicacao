<?php
include_once ('header.php');

if(isset($login)){
	$login = $login;
}else{
	$login = FALSE;
}

?>

<div class="container-fluid">

	<div class="row login">
		<div class="col-xs-1 col-sm-2 col-md-3	col-lg-3"></div>
		<div class="col-xs-10 col-sm-8 col-md-6	col-lg-6">

			<div>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="<?=$login?'':'active'?>">
						<a href="#cadastro" aria-controls="home" role="tab" data-toggle="tab">Cadastro</a>
					</li>
					<li role="presentation" class="<?=$login?'active':''?>">
						<a href="#login" aria-controls="profile" role="tab" data-toggle="tab">Login</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane <?=$login?'':'active'?>" id="cadastro">
						<form class="form-signin" action="/cadastro-add" method="post" enctype="multipart/form-data">
							<h2 class="form-signin-heading text-center">Faça seu Cadastro</h2>
							<?php
							if (isset($retorno_add)) {
								gerarAlerta($retorno_add['msg'], $retorno_add['type']);
							}
							?>
							<div class="form-group">
								<input type="text" id="nome" name="nome" class="form-control input-lg" placeholder="Nome Completo" required autofocus>
								<input type="hidden" id="indicacao" name="indicacao" class="form-control input-lg" placeholder="" value="<?=(isset($indicador)?$indicador:'')?>">
							</div>

							<div class="form-group">
								<input type="email" id="email" name="email" class="form-control input-lg" placeholder="E-mail" required>
							</div>
							<button class="btn btn-lg btn-primary btn-block" type="submit">
								Cadastrar
							</button>
						</form>
					</div>

					<div role="tabpanel" class="tab-pane <?=$login?'active':''?>" id="login">
						<form class="form-signin" action="/login" method="post" enctype="multipart/form-data">
							<h2 class="form-signin-heading text-center">Acesse o sistema</h2>
							<?php
							if (isset($retorno_login)) {
								gerarAlerta($retorno_login['msg'], $retorno_login['type']);
							}
							?>
							<div class="form-group">
								<input type="email" id="email" name="email" class="form-control input-lg" placeholder="E-mail" value="<?=isset($email)?$email:''?>" required>
							</div>
							<button class="btn btn-lg btn-primary btn-block" type="submit">
								Acessar
							</button>
						</form>
					</div>

				</div>

			</div>

		</div>
		<div class="col-xs-1 col-sm-2 col-md-3	col-lg-3"></div>
	</div>

</div>
<!-- /container -->
<?php
include_once ('footer.php');
?>
