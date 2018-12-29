<?php
session_start();
require_once("vendor/autoload.php");
require_once("config.php");
require_once("funcoes.php");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
	'debug'=>TRUE,
	'templates.path' => './views'
));

function dados_sistema(){
	$configuracoes 	= new Configuracoes();
	$configuracao	= $configuracoes->loadId(1);
	return $configuracao; 
}

function email_validacao($id_usuario, $email){
	$link = site_url().'/confirmacao/'.md5($id_usuario);
			
	$conteudo = '<h3>Bem vindo!!!</h3>';
	$conteudo.= '<p>Obrigado por fazer o cadastro no site, para finalizar seu cadastro será necessário acessar o link, <a href="'.$link.'" target="_blank"><em>Clique aqui</em></a></p>';
	$conteudo.= '<br /><p>Caso não consiga acessar o link acime, copie esse link: <em> '.$link.' </em>e colo em seu navegador.</p>';
	
	$dados_sistema	= dados_sistema();
	$envio_email 	= new EnvioEmail();
	$envio		 	= $envio_email->enviar_email($dados_sistema['smtp'], 
												 $dados_sistema['smtp_email'], 
												 $dados_sistema['smtp_senha'], 
												 $dados_sistema['smtp_porta'], 
												 $dados_sistema['smtp_email'], 
												 $dados_sistema['titulo_pagina'],
												 $email, 
												 $dados_sistema['titulo_pagina'], 
												 $conteudo,
												 TRUE,
												 TRUE);
	return $envio;
}

$app->get('/', function() use ($app){
	$app->render('/index.php', array('dados_sistema'=>dados_sistema(), 'login'=>FALSE));
});

$app->get('/ref/:cod_referencia', function($cod_referencia='') use ($app){
	
	if(empty($cod_referencia)){
		$app->redirect('/');
	}else{
		$usuarios = new Usuarios();
		$usuario  = $usuarios->loadCodReferencia($cod_referencia);
		if($usuario){
			$app->render('/index.php', array('dados_sistema'=>dados_sistema(), 'login'=>FALSE, 'indicador'=>$usuario['id']));	
		}else{
			$app->redirect('/');
		}
	}
});

$app->post('/cadastro-add', function() use ($app){
	$retorno_add	= array();
	$usuarios 		= new Usuarios();
	$usuario		= $usuarios->loadEmail($_POST['email']);
	
	if($usuario){
		
		if($usuario['ativo']=='S'){
			$retorno_add = array('error'=>TRUE, 'type'=>'danger', 'msg'=>'Você já possui cadastro, tente acessar o sistema com seu e-mail e sua senha.');	
		}else{
			email_validacao($usuario['id'], $usuario['email']);
			$retorno_add = array('error'=>TRUE, 'type'=>'warning', 'msg'=>'Você já possui cadastro, mas ainda não fez a validação do seu cadastro, enviamos um novo e-mail com link de validação.');
		}
		
	} else {
		$usuario_add = $usuarios->add($_POST);
		if ($usuario_add) {			
			email_validacao($usuario_add, $_POST['email']);			
			$retorno_add = array('success'=>TRUE, 'type'=>'success', 'msg'=>'Cadastro efetuado com sucesso, você receberá um e-mail com um link de validação de cadastro.');
		} else {
			$retorno_add = array('error'=>TRUE, 'type'=>'danger', 'msg'=>'Erro ao efetuar o cadastro ('.$usuario_add.').');
		}		 
	}	
	$app->render('/index.php', array('retorno_add'=>$retorno_add, 'dados_sistema'=>dados_sistema(), 'login'=>FALSE));
});

$app->get('/teste-email', function() use ($app){
	$dados_sistema	= dados_sistema();
	$envio_email 	= new EnvioEmail();
	$envio		 	= $envio_email->enviar_email($dados_sistema['smtp'], 
												 $dados_sistema['smtp_email'], 
												 $dados_sistema['smtp_senha'], 
												 $dados_sistema['smtp_porta'], 
												 'teste@teste.com', 
												 'Nome', 
												 $dados_sistema['smtp_email'], 
												 'Teste', 
												 'Teste', 
												 TRUE, 
												 TRUE);
	verMatriz($envio);
});

$app->get('/confirmacao/:id_usuarios', function($id_usuarios='') use ($app){
    
	if(!empty($id_usuarios)){
		$usuarios = new Usuarios();
		$usuario  = $usuarios->loadIdMd5($id_usuarios);
		
		if($usuario){
			$usuario_edit = $usuarios->edit(array('ativo'=>'S'), array(':ID'=>$usuario['id']));
			
			if($usuario_edit){
				$dados_sistema = dados_sistema();
				
				$integra_busca = IntegracaoMailingBossSearch(array('chave_integracao'	=>$dados_sistema['chave_integracao'],
																   'email'				=>$usuario['email'],
																   'list_uid'			=>$dados_sistema['chave_lista']));			
				
				if(isset($integra_busca) && $integra_busca['status'] == 'error'){
					
					$integra_add = IntegracaoMailingBossAdd(array('chave_integracao'	=>$dados_sistema['chave_integracao'],
																  'email'				=>$usuario['email'],
																  'list_uid'			=>$dados_sistema['chave_lista'],
																  'taginternals'		=>'TAG2,',
																  'status'				=>'confirmed'));
																	 
					if($integra_add['status']=='success'){
						$integra_edit = IntegracaoMailingBossEdit(array('chave_integracao'	=>$dados_sistema['chave_integracao'],
																	    'subscriber_uid'	=>$integra_add['data']['subscriber_uid'],
																	    'list_uid'			=>$dados_sistema['chave_lista'],
																	    'email'				=>$usuario['email'],																	   
																	    'taginternals'		=>$integra_add['data']['taginternals'],
																	    'status'			=>'confirmed'));
					}					
				}
			}
						
			$retorno_login = array('success'=>TRUE, 'type'=>'success', 'msg'=>'Cadastro validado com sucesso, você já pode acessar o sitema.');
			$app->render('/index.php', array('retorno_login'=>$retorno_login, 'dados_sistema'=>dados_sistema(), 'login'=>TRUE, 'salvar_email'=>'1', 'email'=>$usuario['email'], 'nome'=>$usuario['nome']));	
			
		}else{
			echo '<h3><center>Chave de validação não localizada, verifique se copiou o link de seu corretamente.</center></h3>';
			die();
		}
	}else{
		echo '<h3><center>Chave de validação não localizada, verifique se copiou o link de seu corretamente.</center></h3>';
		die();
	}
});

$app->notFound(function () use ($app) {
    $app->render('/404.php', array('dados_sistema'=>dados_sistema()));
});

$app->post('/login', function() use ($app){
	if(isset($_POST)){
		$usuarios = new Usuarios();
		$usuario  = $usuarios->loadEmail($_POST['email']);
		if($usuario){
			if(isset($_SESSION['usuario'])){
				unset($_SESSION['usuario']);
			}
			$_SESSION['usuario'] = $usuario;
			$app->redirect('/principal');
			exit;
		}else{
			$retorno_login = array('error'=>TRUE, 'type'=>'danger', 'msg'=>'Você não possui cadastro com esse E-mail.');
			$app->render('/index.php', array('retorno_login'=>$retorno_login, 'dados_sistema'=>dados_sistema(), 'login'=>TRUE));
		}
	}else{
		$retorno_login = array('error'=>TRUE, 'type'=>'danger', 'msg'=>'Erro ao acessar o sistema, tente novamente..');
		$app->render('/index.php', array('retorno_login'=>$retorno_login, 'dados_sistema'=>dados_sistema(), 'login'=>TRUE));
	}
});

$app->get('/principal(/:qtd)', function($qtd='') use ($app){
	valida_logado();
	$usuarios 					= new Usuarios();
	$dados_sistema				= dados_sistema();
	$qtd_indicados_confimardo 	= $usuarios->loadQtdIndicacoes($_SESSION['usuario']['id'], 'S');
	$qtd_indicados_aguardando 	= $usuarios->loadQtdIndicacoes($_SESSION['usuario']['id'], 'N');
	
	$porcentagem_confirmado		= '';
	if ($qtd_indicados_confimardo['total']==0) {
		$porcentagem_confirmado = 0;
	}else{
		$porcentagem_confirmado = ($qtd_indicados_confimardo['total']/$dados_sistema['max_indicacoes'])*100;
	}
	
	$porcentagem_aguardando		= '';
	if ($qtd_indicados_aguardando['total']==0) {
		$porcentagem_aguardando = 0;
	}else{
		$porcentagem_aguardando = ($qtd_indicados_aguardando['total']/$dados_sistema['max_indicacoes'])*100;
	}
	
	//ATUALIZAÇÃO DA TAG NA LISTA
	if(($qtd_indicados_confimardo['total']==20 || $qtd==20) || ($qtd_indicados_confimardo['total']==12 || $qtd==12)){
		
		$usuario 		= $usuarios->loadId($_SESSION['usuario']['id']);
		$integra_busca  = IntegracaoMailingBossSearch(array('chave_integracao'	=>$dados_sistema['chave_integracao'],
														   'email'				=>$usuario['email'],
														   'list_uid'			=>$dados_sistema['chave_lista']));
		
		if(isset($integra_busca) && $integra_busca['status'] == 'error'){
			
			$integra_add = IntegracaoMailingBossAdd(array('chave_integracao'	=>$dados_sistema['chave_integracao'],
														  'email'				=>$usuario['email'],
														  'list_uid'			=>$dados_sistema['chave_lista'],
														  'taginternals'		=>'INDICOU'.(!empty($qtd)?$qtd:$qtd_indicados_confimardo['total']),
														  'status'				=>'confirmed'));
															 
			if($integra_add['status']=='success'){
				$integra_edit = IntegracaoMailingBossEdit(array('chave_integracao'	=>$dados_sistema['chave_integracao'],
															    'subscriber_uid'	=>$integra_add['data']['subscriber_uid'],
															    'list_uid'			=>$dados_sistema['chave_lista'],
															    'email'				=>$usuario['email'],																	   
															    'taginternals'		=>$integra_add['data']['taginternals'],
															    'status'			=>'confirmed'));
			}					
		} else {
			$integra_edit = IntegracaoMailingBossEdit(array('chave_integracao'	=>$dados_sistema['chave_integracao'],
														    'subscriber_uid'	=>$integra_busca['data']['subscriber_uid'],
														    'list_uid'			=>$dados_sistema['chave_lista'],
														    'email'				=>$usuario['email'],
														    'taginternals'		=>'INDICOU'.(!empty($qtd)?$qtd:$qtd_indicados_confimardo['total']),
														    'status'			=>'confirmed'));
		}	
	
	}
	
    $app->render('/principal.php', array('dados_sistema'				=>dados_sistema(), 
    									 'qtd_indicados_confirmados'	=>(!empty($qtd)?$qtd:$qtd_indicados_confimardo['total']), 
    									 'porcentagem_confimados'		=>$porcentagem_confirmado, 
    									 'qtd_indicados_aguradando'		=>$qtd_indicados_aguardando['total'], 
    									 'porcentagem_aguardando'		=>$porcentagem_aguardando));
});

$app->get('/logout', function() use ($app){
	unset($_SESSION['usuario']);
	$app->redirect('/');
});

$app->run();

?>