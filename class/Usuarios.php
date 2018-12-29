<?php
class Usuarios extends Connection {
		
	private $id;
	private $nome;
	private $email;
	private $senha;
	private $indicacao;
	private $dh_cadastro;
	private $ativo;
	private $cod_referencia;
	
	private function setId($value){
		$this->id = $value;
	}	
	private function getId(){
		return $this->id;
	}
	
	private function setNome($value){
		$this->nome = strtoupper($value);
	}	
	private function getNome(){
		return $this->nome;
	}
	
	private function setEmail($value){
		$this->email = strtolower($value);
	}	
	private function getEmail(){
		return $this->email;
	}
	
	private function setSenha($value){
		$this->senha = md5($value);
	}	
	private function getSenha(){
		return $this->senha;
	}
	
	private function setIndicacao($value){
		$this->indicacao = $value;
	}	
	private function getIndicacao(){
		return $this->indicacao;
	}
	
	private function setDhCadastro($value){
		$this->dh_cadastro = dh_banco($value);
	}	
	private function getDhCadastro(){
		return $this->dh_cadastro;
	}
	
	private function setAtivo($value){
		$this->ativo = $value;
	}	
	private function getAtivo(){
		return $this->ativo;
	}
	
	private function setCodReferencia($value){
		$this->cod_referencia = $value;
	}	
	private function getCodReferencia(){
		return $this->cod_referencia;
	}
	
	private function setValues($values = array()){
		
		if(isset($values['id'])) 				$this->setId($values['id']);
		if(isset($values['nome'])) 				$this->setNome($values['nome']);
		if(isset($values['email']))				$this->setEmail($values['email']);		
		if(isset($values['senha'])) 			$this->setSenha($values['senha']);
		if(isset($values['indicacao'])) 		$this->setIndicacao($values['indicacao']);
		if(isset($values['dh_cadastro'])) 		$this->setDhCadastro($values['dh_cadastro']);
		if(isset($values['ativo'])) 			$this->setAtivo($values['ativo']);
		if(isset($values['cod_referencia']))	$this->setCodReferencia($values['cod_referencia']);
	}
	
	private function getValues(){
		
		if($this->getId()) 					$values['id'] 				= $this->getId();
		if($this->getNome()) 				$values['nome']				= $this->getNome();
		if($this->getEmail()) 				$values['email'] 			= $this->getEmail();
		if($this->getSenha()) 				$values['senha'] 			= $this->getSenha();
		if($this->getIndicacao())			$values['indicacao']		= $this->getIndicacao();
		if($this->getDhCadastro()) 			$values['dh_cadastro'] 		= $this->getDhCadastro();
		if($this->getAtivo()) 				$values['ativo'] 			= $this->getAtivo();
		if($this->getCodReferencia())		$values['cod_referencia']	= $this->getCodReferencia();
		
		return $values;
	}
	
	public function loadId($id){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_usuarios WHERE id = :ID", array(':ID'=>$id));
		if (isset($lista[0])) {
			return $lista[0];
		} else {
			return FALSE;
		}
	}
	
	public function loadIdMd5($id){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_usuarios WHERE md5(id) = :ID", array(':ID'=>$id));
		if (isset($lista[0])) {
			return $lista[0];
		} else {
			return FALSE;
		}
	}
	
	public function loadCodReferencia($cod_referencia){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_usuarios WHERE cod_referencia = :COD_REFERENCIA", array(':COD_REFERENCIA'=>$cod_referencia));
		if (isset($lista[0])) {
			return $lista[0];
		} else {
			return FALSE;
		}
	}
	
	public function loadEmail($email){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_usuarios WHERE email = :EMAIL", array(':EMAIL'=>strtolower($email)));
		if (isset($lista[0])) {
			return $lista[0];
		} else {
			return FALSE;
		}
	}
	
	public function loadQtdIndicacoes($id_usuarios, $ativo = 'S'){
		$conn = new Connection();
		$lista = $conn->select("SELECT count(1) as total FROM tb_usuarios WHERE indicacao = :ID_USUARIOS and ativo = :ATIVO", array(':ID_USUARIOS'=>$id_usuarios, ':ATIVO'=>$ativo));
		if (isset($lista[0])) {
			return $lista[0];
		} else {
			return FALSE;
		}
	}	
	
	public function load(){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_usuarios ORDER BY nome", array());
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
		
		$insert = $conn->insert('tb_usuarios', $arr);
		if($insert){
			$cod_referencia = md5(date('dmYHis').$insert);
			$cod_referencia = substr($cod_referencia, 0, 5);
			$edit = $this->edit(array('cod_referencia'=>$cod_referencia), array(':ID'=>$insert));
		}
		return $insert;
	}
	
	public function del($values=array()){
		$conn = new Connection();
		$delete = $conn->delete('tb_usuarios', $values);
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
		$edit = $conn->update('tb_usuarios', $arr, $where);
		return $edit;
	}
}
?>