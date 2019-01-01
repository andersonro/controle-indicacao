<?php
class Links extends Connection {

	private $id;
	private $qtd_cadastros;
	private $link;

	private function setId($value){
		$this->id = $value;
	}
	private function getId(){
		return $this->id;
	}

	private function setQtdCadastros($value){
		$this->qtd_cadastros = strtoupper($value);
	}
	private function getQtdCadastros(){
		return $this->qtd_cadastros;
	}

	private function setLink($value){
		$this->link = strtolower($value);
	}
	private function getLink(){
		return $this->link;
	}

	private function setValues($values = array()){

		if(isset($values['id'])) 							$this->setId($values['id']);
		if(isset($values['qtd_cadastros'])) 	$this->setNome($values['qtd_cadastros']);
		if(isset($values['link']))					  $this->setEmail($values['link']);
	}

	private function getValues(){

		if($this->getId()) 						$values['id'] 						= $this->getId();
		if($this->getQtdCadastros()) 	$values['qtd_cadastros']	= $this->getQtdCadastros();
		if($this->getLink()) 					$values['link'] 					= $this->getLink();

		return $values;
	}

	public function loadId($id){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_links WHERE id = :ID", array(':ID'=>$id));
		if (isset($lista[0])) {
			return $lista[0];
		} else {
			return FALSE;
		}
	}

	public function load(){
		$conn = new Connection();
		$lista = $conn->select("SELECT * FROM tb_links ORDER BY id", array());
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

		$insert = $conn->insert('tb_links', $arr);
		if($insert){
			$cod_referencia = md5(date('dmYHis').$insert);
			$cod_referencia = substr($cod_referencia, 0, 5);
			$edit = $this->edit(array('cod_referencia'=>$cod_referencia), array(':ID'=>$insert));
		}
		return $insert;
	}

	public function del($values=array()){
		$conn = new Connection();
		$delete = $conn->delete('tb_links', $values);
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
		$edit = $conn->update('tb_links', $arr, $where);
		return $edit;
	}
}
?>
