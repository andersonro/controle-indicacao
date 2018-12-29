<?php
function site_url(){
 
    if(!empty($_SERVER["HTTPS"])){
		if($_SERVER["HTTPS"]!=="off"){
	    	return 'https://'.$_SERVER['SERVER_NAME'];  
		} else {
	    	return 'http://'.$_SERVER['SERVER_NAME'];
		}
    } else {
		return 'http://'.$_SERVER['SERVER_NAME'];
    }
}

function verMatriz($vetor){
	echo '<pre>';
		var_dump($vetor);
	echo '</pre>';
}

function numberformat($valor, $simbolo=true, $decimal=2){
	$valor = ($simbolo?'R$ ':'').number_format($valor, $decimal, ',', '.'); 
	return $valor;
}

function numberFormatBanco($valor){
	$valor = str_replace('R$ ', '', $valor);
	$valor = str_replace('.', '', $valor);
	$valor = str_replace(',', '.', $valor);
	return $valor;
}

function dt_banco($dt){
	if ($dt) {
		$dt = explode('/', $dt);
		$data = $dt[2].'-'.$dt[1].'-'.$dt[0]; 
	} else {
		$data = '';
	}
	return $data; 
}

function dh_banco($dh){
	
	$dh = explode(' ', trim($dh));
	
	if ($dh[0]) {
		$dt = explode('/', $dh[0]);
		$data = $dt[2].'-'.$dt[1].'-'.$dt[0].' '.$dh[1]; 
	} else {
		$data = '';
	}
	return $data; 
}

function dt_br($dt){
	if ($dt) {
		$data = date('d/m/Y', strtotime($dt)); 
	} else {
		$data = '';
	}
	return $data; 
}

function dh_br($dt){
	if ($dt) {
		$dh = date('d/m/Y H:i:s', strtotime($dt)); 
	} else {
		$dh = ''; 
	}
	
	return $dh;
}

function dias_semana($numero){
	switch ($numero) {
	    case 0:
	        return 'Domingo';
	        break;
	    case 1:
	        return 'Segunda-Feira';
	        break;
	    case 2:
	        return 'Terça-Feira';
	        break;
		case 3:
	        return 'Quarta-Feira';
	        break;
		case 4:
	        return 'Quinta-Feira';
	        break;
		case 5:
	        return 'Sexta-Feira';
	        break;
		case 6:
	        return 'Sábado';
	        break;
	}
}

function hoje(){
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	return date('Y-m-d');
}

function somar_dias($dt, $qtd){
	return date('Y-m-d', strtotime('+'.$qtd.' days', strtotime($dt)));
}

function somar_meses($dt, $qtd){
	return date('Y-m-d', strtotime('+'.$qtd.' month', strtotime($dt)));
}

function diferenca_datas($dt_maior, $dt_menor){
	$dt_maior = strtotime($dt_maior);
	$dt_menor = strtotime($dt_menor);
	$diferenca = $dt_maior - $dt_menor;
	$dias = (int)floor($diferenca/(60*60*24));
	return $dias;
}

function dia_semana($dt){
	return date('w', strtotime($dt));
}

function compara_datas($dt1, $dt2){
	
	$str_dt1 = strtotime($dt1);
	$str_dt2 = strtotime($dt2);
	
	if (($str_dt1-$str_dt2)>0) {
		$return = '1';
	} else if(($str_dt1-$str_dt2)==0) {
		$return = '0';
	} else {
		$return = '-1';		
	}
	
	return $return;
	
}

function mes_abreviado($mes){
	switch ($mes) {
    	case '01':
    		$mes = 'Jan';
    		break;
    	case '02':
    		$mes = 'Fev';
    		break;
    	case '03':
    		$mes = 'Mar';
    		break;
		case '04':
    		$mes = 'Abr';
    		break;
		case '05':
    		$mes = 'Mai';
    		break;
		case '06':
    		$mes = 'Jun';
    		break;
		case '07':
    		$mes = 'Jul';
    		break;
		case '08':
    		$mes = 'Ago';
    		break;
		case '09':
    		$mes = 'Set';
    		break;
		case '10':
    		$mes = 'Out';
    		break;
		case '11':
    		$mes = 'Nov';
    		break;
		case '12':
    		$mes = 'Dez';
    		break;
    	}	
    return $mes;
}

function mes_extenso($mes){
	switch ($mes) {
    	case '01':
    		$mes = 'Janeiro';
    		break;
    	case '02':
    		$mes = 'Fevereiro';
    		break;
    	case '03':
    		$mes = 'Março';
    		break;
		case '04':
    		$mes = 'Abril';
    		break;
		case '05':
    		$mes = 'Maio';
    		break;
		case '06':
    		$mes = 'Junho';
    		break;
		case '07':
    		$mes = 'Julho';
    		break;
		case '08':
    		$mes = 'Agosto';
    		break;
		case '09':
    		$mes = 'Setembro';
    		break;
		case '10':
    		$mes = 'Outubro';
    		break;
		case '11':
    		$mes = 'Novembro';
    		break;
		case '12':
    		$mes = 'Dezembro';
    		break;
    	}	
    return $mes;
}

function retorna_idade($dt){
	$data = dt_br($dt);   
    // Separa em dia, mês e ano
    list($dia, $mes, $ano) = explode('/', $data);   
    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);   
    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    return $idade;
}

function mover_arquivo($arquivo, $dir, $nome){
	if (file_exists($dir)) {
		$mover = move_uploaded_file($arquivo, $dir.'/'.$nome);
		if($mover){
			return TRUE;
		}else{
			return $mover;
		}
			
	}else{
		return FALSE;
	}
}

function somar_datas($numero, $tipo){
	switch ($tipo) {
    	case 'd':
    		$tipo = ' day';
    		break;
    	case 'm':
    		$tipo = ' month';
    		break;
    	case 'y':
    		$tipo = ' year';
    		break;
    	}	
    return "+".$numero.$tipo;
}

function valida_logado(){
	if(!isset($_SESSION['usuario'])){
		header('Location: '.site_url().'/logout');
		exit;
	}
}

function limpa_numero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

function preencheZero($nro, $qtde){
	return str_pad($nro, $qtde, '0', STR_PAD_LEFT);
}

function mascara($val='', $mask=''){
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++) {
        if($mask[$i] == '#') {
            if(isset($val[$k])) $maskared .= $val[$k++];
        }else {
            if(isset($mask[$i])) $maskared .= $mask[$i];
        }
    }
 return $maskared;
}

function formato_moeda($valor){
	return number_format((isset($valor)?$valor:0.00),'2',',','.');
}

function extensoes_permitidos(){
	return array('pdf','jpg','png');
}

function By2M($size){
    $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
}

function IntegracaoMailingBoss($values = array()){
	$CHAVE_INTEGRACAO = $values['chave_integracao'];
	unset($values['chave_integracao']);	
	$link = "http://member.mailingboss.com/integration/index.php/lists/".$CHAVE_INTEGRACAO;	
	$ch = curl_init($link);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response, TRUE);
}

function IntegracaoMailingBossSearch($values = array()){
	$CHAVE_INTEGRACAO = $values['chave_integracao'];
	unset($values['chave_integracao']);
	$link = "http://member.mailingboss.com/integration/index.php/lists/subscribers/search-by-email/".$CHAVE_INTEGRACAO;	
	$ch = curl_init($link);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $values);	
	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response, TRUE);
}

function IntegracaoMailingBossAdd($values = array()){
	$CHAVE_INTEGRACAO = $values['chave_integracao'];
	unset($values['chave_integracao']);
	$link = "http://member.mailingboss.com/integration/index.php/lists/subscribers/create/".$CHAVE_INTEGRACAO;	
	$ch = curl_init($link);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $values);	
	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response, TRUE);
}

function IntegracaoMailingBossEdit($values = array()){
	$CHAVE_INTEGRACAO = $values['chave_integracao'];
	unset($values['chave_integracao']);
	$link = "http://member.mailingboss.com/integration/index.php/lists/subscribers/update/".$CHAVE_INTEGRACAO;	
	$ch = curl_init($link);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $values);	
	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response, TRUE);
}

// <!-- OBJETOS HTML -->

function gerarAlerta($msg='', $type = 'info', $center = TRUE, $strong = TRUE, $close = TRUE){
	$alerta = '<div class="alert alert-'.$type.' alert-dismissible fade in '.($center?'text-center':'').'" role="alert">';
		if($close) $alerta .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		if($strong) $alerta .= '<strong>';
			$alerta .= $msg;
		if($strong) $alerta .= '</strong>';
	$alerta .= '</div>'; 
	echo $alerta;
}

// <!-- / OBJETOS HTML -->
?>