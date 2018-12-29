<?php
class Configuracoes extends Connection {
		
	private $id;
	private $smtp_email;
	private $smtp;
	private $smtp_senha;
	private $smtp_porta;
	private $titulo_pagina;
	
	private function setId($value){
		$this->id = $value;
	}	
	private function getId(){
		return $this->id;
	}
	
	private function setSmtpEmail($value){
		$this->smtp_email = strtolower($value);
	}	
	private function getSmtpEmail(){
		return $this->smtp_email;
	}
	
	private function setSmtp($value){
		$this->smtp = $value;
	}	
	private function getSmtp(){
		return $this->smtp;
	}
	
	private function setSmtpSenha($value){
		$this->smtp_senha = $value;
	}	
	private function getSmtpSenha(){
		return $this->smtp_senha;
	}
	
	private function setSmtpPorta($value){
		$this->smtp_porta = $value;
	}	
	private function getSmtpPorta(){
		return $this->smtp_porta;
	}	
	
	private function setTituloPagina($value){
		$this->titulo_pagina = $value;
	}	
	private function getTituloPagina(){
		return $this->titulo_pagina;
	}
	
	private function setValues($values = array()){
		
		if(isset($values['id'])) 					$this->setId($values['id']);
		if(isset($values['smtp_email'])) 			$this->setSmtpEmail($values['smtp_email']);
		if(isset($values['smtp']))					$this->setSmtpEmail($values['smtp']);		
		if(isset($values['smtp_senha'])) 			$this->setSmtpSenha($values['smtp_senha']);
		if(isset($values['smtp_porta'])) 			$this->setSmtpPorta($values['smtp_porta']);
		if(isset($values['titulo_pagina'])) 		$this->setTituloPagina($values['titulo_pagina']);
	}
	
	private function getValues(){
		
		if($this->getId()) 					$values['id'] 				= $this->getId();
		if($this->getSmtpEmail())			$values['smtp_email']		= $this->getSmtpEmail();
		if($this->getSmtp()) 				$values['smtp'] 			= $this->getSmtp();
		if($this->getSmtpSenha())			$values['smtp_senha']		= $this->getSmtpSenha();
		if($this->getSmtpPorta())			$values['smtp_porta']		= $this->getSmtpPorta();
		if($this->getTituloPagina())		$values['titulo_pagina']	= $this->getTituloPagina();
		
		return $values;
	}
	
	public function loadId($id){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_configuracoes WHERE id = :ID", array(':ID'=>$id));
		if (isset($lista[0])) {
			return $lista[0];
		} else {
			return FALSE;
		}
	}
	
	public function load(){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_configuracoes ORDER BY id", array());
		if (isset($lista[0])) {
			return $lista;
		} else {
			return FALSE;
		}
	}
		
	public function add($values=array()){
		$conn = new Connection();
		
		$this->setValues($values);
				
		$arr = array();
		foreach ($this->getValues() as $key => $value) {
			if(!empty($value)){
				$arr[':'.strtoupper($key)] = $value;
			}
		}
		
		$insert = $conn->insert('tb_configuracoes', $arr);
		return $insert;
	}
	
	public function del($values=array()){
		$conn = new Connection();
		$delete = $conn->delete('tb_configuracoes', $values);
		return $delete;
	}
	
	public function edit($values=array(), $where = array()){
		$this->setValues($values);
		$arr = array();
		foreach ($this->getValues() as $key => $value) {
			if(!empty($value)){
				$arr[':'.strtoupper($key)] = $value;
			}
		}
		$conn = new Connection();
		$edit = $conn->update('tb_configuracoes', $arr, $where);
		return $edit;
	}
}
?>