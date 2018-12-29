<?php
include_once ('header.php');
?>

<div class="container-fluid">

	<div class="row">
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		<div class="col-xs-12 col-sm-8 col-md-6	col-lg-8">
			<img src="<?=site_url()?>/layout/images/infinity3.jpg" class="img-responsive center-block" style="max-height: 200px" />
		</div>
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
	</div>
	<br />
	<div class="row">
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		<div class="col-xs-12 col-sm-8 col-md-6	col-lg-8 text-right">
			<?php
			echo '<i class="glyphicon glyphicon-user"></i> '.$_SESSION['usuario']['nome'].' - <a href="/logout">SAIR</a>'
			//include_once('menu.php');
			?>
		</div>
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
	</div>
	<br />
	<div class="row">
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		<div class="col-xs-12 col-sm-8 col-md-6	col-lg-8">
			<h4>
				<?php
				//$meu_link = site_url().'/ref/'.$_SESSION['usuario']['cod_referencia'];
				$meu_link = 'http://www.superlucrativo.com?ref='.$_SESSION['usuario']['cod_referencia'];
				?>
				<!-- Seu link de indicação: <small id="link-small"><?=$meu_link?></small> -->
				<form class="form-horizontal">
					<div class="form-group"> 
						<label for="meu-link" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">Seu link de indicação:</label>
						<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 input-group">
							<input type="text" id="link" name="link" class="form-control" readonly="readonly" value="<?=$meu_link?>" />
							<span class="input-group-addon"><a href="#" class="" rel="btn-copiar-link" title="Copiar"><i class="glyphicon glyphicon-share"></i></a></span>
						</div>
					</div>
				</form>
			</h4>
			
			<?php
			gerarAlerta('Para conseguir seu prêmio é necessário ter 20 indicações e que eles confirmem o cadastro, indique o maior número de amigos, <a href="#" rel="video-como-fazer">clique aqui veja como fazer</a>.', 'info', TRUE, TRUE, FALSE);
			?>
		</div>
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
	</div>
	<br />
	<div class="row">
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		<div class="col-xs-12 col-sm-8 col-md-6	col-lg-8">
			<h4>Compartilhar nas redes sociais</h4>	
		</div>
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
	</div>
	<div class="row">
		
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		
		<div class="col-xs-12 col-sm-2 col-md-1	col-lg-1">
			<div class="fb-share-button" data-href="<?=$meu_link?>" data-layout="button_count" data-size="small" data-mobile-iframe="true">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Faroservicos.xyz%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a>
			</div>
					
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2	col-lg-1">
			<a href="https://web.whatsapp.com/send?text=<?=$meu_link?>" target="_blank">
				<span class="label label-success">
					<img src="<?=site_url()?>/layout/images/icone_whats.png" style="width: 25px; height: 25px" /> 
					Whatsapp Web
				</span>
			</a>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-1	col-lg-1">
			<a href="http://twitter.com/share" class="twitter-share-button"
			data-url="<?=$meu_link?>" data-text="Teste" data-count="horizontal" data-via="<?=$dados_sistema['titulo_pagina']?>" data-lang="pt">Tweetar</a>
			<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>		
		</div>
		
		<div class="col-xs-0 col-sm-2 col-md-1	col-lg-1"></div>
	</div>
	<br />
	<div class="row">
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		<div class="col-xs-12 col-sm-8 col-md-6	col-lg-8">
			<p class="">Você possui a quantidade de <strong><?=$qtd_indicados_confirmados?></strong> indicados que se cadastraram e confirmaram através do seu link de indicação.</p>
			<div class="progress">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$qtd_indicados_confirmados?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$porcentagem_confimados==0?2:$porcentagem_confimados?>%;">
					<?=$porcentagem_confimados?>%
				</div>
			</div>
			<p class="">Você possui a quantidade de <strong><?=$qtd_indicados_aguradando?></strong> aguardando a confirmação de cadastro.</p>
			<div class="progress">
				<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?=$qtd_indicados_aguradando?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$porcentagem_aguardando==0?2:$porcentagem_aguardando?>%;">
					<?=$porcentagem_aguardando?>%
				</div>
			</div>
		</div>
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
	</div>
	
	<br />
	<div class="row">		
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		<div class="col-xs-12 col-sm-8 col-md-6	col-lg-8">
			<?php
			$img = '';
			if($qtd_indicados_confirmados<12){
				$img = 'thanos2-1280x566.jpg';
			}else if($qtd_indicados_confirmados>=12 && $qtd_indicados_confirmados<20){
				$img = 'img3.png';
			}else{
				$img = 'img4.jpg';
			}
			?>
			<img src="<?=site_url()?>/layout/images/<?=$img?>" class="img-responsive center-block" style="max-height: 250px" />
		</div>
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
	</div>
	<br />
	
	
	<div class="row">
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
		<div class="col-xs-12 col-sm-8 col-md-6	col-lg-8">
		<?php
		$link_compra = '';
		if($qtd_indicados_confirmados<12){
			gerarAlerta('Você ainda não possui indicações cadastras e confirmadas, mas se desejar adquirir o seu prêmio acesse o link: <a href="'.$link_compra.'" target="_blank">Adquira aqui seu Prẽmio</a>', 'warning', TRUE, TRUE, FALSE);
		}else if($qtd_indicados_confirmados>=12 && $qtd_indicados_confirmados<20){
			gerarAlerta('Com a quantidade de '.$qtd_indicados_confirmados.', você consegui adquirir o seu prêmio com 50% de desconto, acesse o link: <a href="'.$link_compra.'" target="_blank">Adquira aqui seu Prẽmio</a>', 'warning', TRUE, TRUE, FALSE);
		}else{
			gerarAlerta('Parabêns você conseguiu a quantidade de indicados, acesse o link: <a href="'.$link_compra.'" target="_blank">Adquira aqui seu Prẽmio</a>, e recebe seu prêmio', 'success', TRUE, TRUE, FALSE);
		}
		?>
		</div>
		<div class="col-xs-0 col-sm-2 col-md-3	col-lg-2"></div>
	</div>
	
</div>
<!-- /container -->

<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="LabelComoFazer">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="LabelComoFazer">Como fazer</h4>
			</div>
			<div class="modal-body text-center">
				<iframe width="560" height="400" src="https://www.youtube.com/embed/g6ng8iy-l0U" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Fechar
				</button>
			</div>
		</div>
	</div>
</div>


<?php
include_once ('footer.php');
?>
<script>

$(document).ready(function(){
	$(document).on('click', 'a[rel=btn-copiar-link]', function(e){
		e.preventDefault();
		var copyText = document.getElementById("link");
	  	copyText.select();
	  	document.execCommand("copy");
	});
	
	$(document).on('click', 'a[rel=video-como-fazer]', function(e){
		e.preventDefault();
		$('#modal-video').modal('show');
	});
	
});
</script>
