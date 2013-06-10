<?php
class Contact extends Base {
    private $name;
    private $email;
    private $content;

    public function setName($name) {
      $this->name = $name;
    }

    public function getName() {
      return $this->name;
    }

    public function setContent($content) {
      $this->content= $content;
    }

    public function getContent() {
      return $this->content;
    }

    public function setEmail($email) {
      $this->email = $email;
    }

    public function getEmail() {
      return $this->email;
    }

    public function validates() {
      Validations::notEmpty($this->name, 'name', $this->errors);
      Validations::notEmpty($this->email, 'email', $this->errors);
      Validations::validEmail($this->email, 'email', $this->errors);
      Validations::notEmpty($this->content, 'content', $this->errors);
    }

    public function save() {
      if (!$this->isvalid()) return false;
      
      $sql = "INSERT INTO contacts (name, email, content, createdAt) VALUES ($1, $2, $3, $4) RETURNING ID;";
      $params = array($this->name, $this->email, $this->content, $this->createdAt);
      $resp = pg_query_params(Database::getConnection(), $sql, $params);

      if (!$resp) {
        return false;
      }
      
      $this->id = pg_fetch_row($resp)[0];
      return true;
    }

    public static function all() {
      $sql = "select * from contacts;";
      $resp = pg_query(Database::getConnection(), $sql);
      $contacts = array();

      while ($row = pg_fetch_assoc($resp)) {
        $contacts[] = new Contact($row);
      }
      return $contacts;
    }
}
?>