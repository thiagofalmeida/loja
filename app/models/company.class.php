<?php 
	class Company extends Client {
		public $socialReason;
		public $name;
		public $ie;
		public $cnpj;

    public function validates() {
      Validations::notEmpty($this->name, 'name', $this->errors);
      Validations::notEmpty($this->socialReason, 'socialReason', $this->errors);
      Validations::notEmpty($this->street, 'street', $this->errors);
      Validations::notEmpty($this->city, 'city', $this->errors);
      Validations::notEmpty($this->neighboorhood, 'neighboorhood', $this->errors);
      Validations::notEmpty($this->num, 'num', $this->errors);  
      Validations::notEmpty($this->password, 'password', $this->errors);
      Validations::notEmpty($this->state, 'state', $this->errors);
      Validations::notEmpty($this->ie, 'ie', $this->errors);

      Validations::uniqueField($this->email, 'email', 'users', 'email', $this->errors);
      Validations::validEmail($this->email, 'email', $this->errors);
      Validations::validPhone($this->phone, 'phone', $this->errors);
      Validations::validCnpj($this->cnpj, 'cnpj', $this->errors);
      Validations::validCep($this->cep, 'cep', $this->errors);
    }

		public function setName($name){
     $this->name = $name;
    }

    public function getName(){
      return $this->name;
    } 

    public function setSocialreason($socialReason){
      $this->socialReason = $socialReason;
    }

  	public function getSocialreason(){
    	return $this->socialReason;
  	}

  	public function setIe($ie){
    	$this->ie = $ie;
  	}

  	public function getIe(){
    	return $this->ie;
  	}

  	public function setCnpj($cnpj){
    	$this->cnpj = $cnpj;
  	}

  	public function getCnpj(){
    	return $this->cnpj;
  	}

  	public function save() {
  		if (!$this->isvalid()) return false;
        $sql = "INSERT INTO company (name, email, password, phone, num, neighboorhood, city, state, cep, street, socialReason, cnpj, ie, createdAt) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14) RETURNING ID;";

			  # sha1 criptografa a senha, porém é mais recomendado a utilização de um Blowfish, pesquise sobre!!
  			$params = array($this->name, $this->email, sha1($this->password), $this->phone, $this->num, $this->neighboorhood, $this->city, $this->state, $this->cep, $this->street, $this->socialReason, $this->cnpj, $this->ie, $this->createdAt);
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