<?php 
	class Common extends Client {
		public $dtnasc;
		public $name;
		public $sex;
		public $cpf;

    public function validates() {
      Validations::notEmpty($this->name, 'name', $this->errors);
      Validations::notEmpty($this->street, 'street', $this->errors);
      Validations::notEmpty($this->city, 'city', $this->errors);
      Validations::notEmpty($this->neighboorhood, 'neighboorhood', $this->errors);
      Validations::notEmpty($this->num, 'num', $this->errors);  
      Validations::notEmpty($this->state, 'state', $this->errors);
      Validations::notEmpty($this->password, 'password', $this->errors);
      Validations::notEmpty($this->dtnasc, 'dtnasc', $this->errors);
      
      Validations::validEmail($this->email, 'email', $this->errors);
      Validations::uniqueField($this->email, 'email', 'users', 'email', $this->errors); 
      Validations::uniqueField($this->cpf, 'cpf', 'common', 'cpf', $this->errors);
      Validations::validPhone($this->phone, 'phone', $this->errors);
      Validations::validDate($this->dtnasc, 'dtnasc', $this->errors);
      Validations::dateNotValid($this->dtnasc, 'dtnasc', $this->errors);
      Validations::ageInappropriate($this->dtnasc, 'dtnasc', $this->errors);
      Validations::validCpf($this->cpf, 'cpf', $this->errors);
      Validations::validCep($this->cep, 'cep', $this->errors);
    }

		public function setName($name){
     $this->name = $name;
    }

    public function getName(){
      return $this->name;
    } 

    public function setDtnasc($dtnasc){
      $this->dtnasc = $dtnasc;
    }

  	public function getDtnasc(){
    	return $this->dtnasc;
  	}

  	public function setSex($sex){
    	$this->sex = $sex;
  	}

  	public function getSex(){
    	return $this->sex;
  	}

  	public function setCpf($cpf){
    	$this->cpf = $cpf;
  	}

  	public function getCpf(){
    	return $this->cpf;
  	}

  	public function save() {
  		if (!$this->isvalid()) return false;
        $sql = "INSERT INTO common (name, email, password, phone, num, neighboorhood, city, state, cep, street, dtnasc, cpf, sex, createdAt) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14) RETURNING ID;";

			  # sha1 criptografa a senha, porém é mais recomendado a utilização de um Blowfish, pesquise sobre!!
  			$params = array($this->name, $this->email, sha1($this->password), $this->phone, $this->num, $this->neighboorhood, $this->city, $this->state, $this->cep, $this->street, $this->dtnasc, $this->cpf, $this->sex, $this->createdAt);
  			$db_conn = Database::getConnection();
  			$resp = pg_query_params($db_conn, $sql, $params);

  			if (!$resp) {
  				Logger::getInstance()->log("Falha para salvar o objeto: " . print_r($this, TRUE), Logger::ERROR);
  				Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
  				pg_close($db_conn);
  				return false;
  			}

  			$this->setId(pg_fetch_assoc($resp)['id']);
  			pg_close($db_conn);
  			return true;
 		}
	} 
?>