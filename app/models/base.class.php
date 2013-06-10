<?php
  abstract class Base {
    protected $id;
    protected $createdAt;
    protected $errors = array();

    public function __construct($data = array()){
      $this->createdAt = date('Y-m-d H:i:s');
      foreach($data as $key => $value){
        $method = "set{$key}";
        $this->$method($value);
      }
    }

    abstract function validates();

    public function getId() {
      return $this->id;
    }

    public function setId($id) {
      $this->id = $id;
    }

    public function getCreatedAt(){
      return $this->createdAt;
    }

    public function setCreatedAt($createdAt){
      $this->createdAt = $createdAt;
    }

    public function errors($index = null) {
      if ($index == null)
        return $this->errors;

      if (isset($this->errors[$index]))
        return $this->errors[$index];

      return false;
    }

    public function isValid() {
      $this->errors = array();
      $this->validates();
      return empty($this->errors);
    }
  }
?>