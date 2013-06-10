<?php
class ProductPhoto extends Photo {
  private $productId;

  public function __construct($data = array()){
    $data['tmpname'] = $data['tmp_name'];
    unset($data['error']);
    unset($data['tmp_name']);
    foreach($data as $key => $value){
      $method = "set{$key}";
      $this->$method($value);
    }
  }

  public function setProductId($productId){
    $this->productId = $productId;
  }

  public function getProductId(){
    return $this->productId;
  }

  public function isValid() {
      $this->errors = array();

      if (Validations::notEmpty($this->name)) {
        Validations::lessThen($this->size, 1024*1024, $this->errors['size']);
        Validations::inclusionIn($this->type, array('img/jpeg','img/jpg','img/png','img/gif'), $this->errors['type']);

        $this->errors = array_filter($this->errors, 'Validations::notEmpty');
      }

      return empty($this->errors);
  }

  public static function findByProductId($id){
      $sql = "select * from product_photo where product_id = $1;";
      $resp = pg_query_params(Database::getConnection(), $sql, array($id));

      if (pg_affected_rows($resp) > 0) {
        $row = pg_fetch_assoc($resp);
        $row['productid'] = $row['product_id'];
        unset($row['product_id']);
        return new ProductPhoto($row);
      }

      return null;
  }

  public function save() {
    if ($this->isValid()) {
      $this->savePhotoInDisc();
      $sql = "insert into product_photo (name, type, size, folder, product_id) values ($1, $2, $3, $4, $5) RETURNING ID;";

      $params = array($this->name, $this->type, $this->size, $this->folder, $this->productId);
      $resp = pg_query_params(Database::getConnection(), $sql, $params);

      if (!$resp)
        return false;

      $this->id = pg_fetch_row($resp)[0];
      return true;
    }
    
    return false;
  }

  public function delete(){
    $sql = "delete from product_photo where id = $1;";
    $params = array($this->id);
    $resp = pg_query_params(Database::getConnection(), $sql, $params);
    //remove o arquivo do disco
    unlink(APP_ROOT . $this->folder);
    if (!$resp)
      return false;

    return true;
  }

  private function savePhotoInDisc(){
    // Pega extensão da imagem
    preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $this->name, $ext);

    // Gera um nome único para a imagem
    $this->name = md5(uniqid(time())) . "." . $ext[1];

    // monta o caminho da imagem
    $this->folder = IMAGE_folder . 'products/' . $this->name;
    // move a imagem para o caminho
    move_uploaded_file($this->tmp_name, APP_ROOT . $this->folder);
  }
}
?>