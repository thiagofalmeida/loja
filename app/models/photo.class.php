<?php
  class Photo extends Base {

    const DEFAULT_IMAGE = 'default.jpg';
    private $name = Photo::DEFAULT_IMAGE;
    private $size;
    private $type;
    private $tmp_name;
    private $folder;
    private $error;

    public function __construct($data = array(), $folder){

      parent::__construct($data);
      $this->folder = $folder;
      $this->generateName();
    }

    public function setName($name) {
      if (empty($name))
        $this->name = Photo::DEFAULT_IMAGE;
      else
        $this->name = $name;
    }

    public function getName(){
      return $this->name;
    }

    public function setType($type){
      $this->type = $type;
    }

    public function getType(){
      return $this->type;
    }

    public function setSize($size){
      $this->size = $size;
    }

    public function getSize(){
      return $this->size;
    }

    public function setFolder($folder){
      $this->folder = $folder;
    }

    public function getFolder(){
      return $this->folder;
    }

    public function setTmp_Name($tmp_name){
      $this->tmp_name = $tmp_name;
    }

    public function getTmp_Name(){
      return $this->tmp_name;
    }

    public function setError($error) {
      $this->error = $error;
    }

    public function getError() {
      return $this->error;
    }

    public function validates() {
     // if ($this->hasImage()) {
        //Validations::lessThen($this->size, 1024*1024*1024, 'size', $this->errors); // menor que 3 megabytes
        //Validations::inclusionIn($this->type,array('image/jpeg','image/jpg','image/png','image/gif'),'type', $this->errors);
      //}
    }

    public function hasImage() {
      return (!empty($this->name) && $this->name != Photo::DEFAULT_IMAGE);
    }

    public function getPathToOriginal() {
      return $this->getPath('original');
    }

	  public function getPathToThumb() {
		  return $this->getPath('thumb');
	  }

    public function getPathToDetail() {
      return $this->getPath('detail');
    }

    public function getPathToList() {
      return $this->getPath('list');
    }
	
    public function saveToDisc() {
      move_uploaded_file($this->tmp_name, $this->getPathToOriginal());
	    require 'wideimage/WideImage.php';
      WideImage::load($this->getPathToOriginal())->resize(500,500)->saveToFile($this->getPathToOriginal());
	    WideImage::load($this->getPathToOriginal())->resize(100,70)->saveToFile($this->getPathToThumb());
      WideImage::load($this->getPathToOriginal())->resize(250,200)->saveToFile($this->getPathToDetail());
      WideImage::load($this->getPathToOriginal())->resize(150,150)->saveToFile($this->getPathToList());
    }

    private function getPath($type) {
      return APP_ROOT_FOLDER . '/app/assets/img/photos/' . $this->folder . '/'. $type .'/' .
      $this->name;
    }

    private function generateName() {
      if ($this->hasImage()) {
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $this->name, $ext);

        if ($ext) $this->name = md5(uniqid(time())) . '.' . $ext[1];
      }
    }

    public function delete() {
      if ($this->name != Photo::DEFAULT_IMAGE) {
        unlink($this->getPathToOriginal());
		    unlink($this->getPathToThumb());
        unlink($this->getPathToList());
        unlink($this->getPathToDetail());
      }
    }

    public function update() {
      if (!$this->isValid()) return false;
   
      if ($this->photo && $this->photo->hasImage()) {
        $oldPhoto = new Photo(array(), 'products');
        $oldPhoto->setName($this->photoName);
        $oldPhoto->delete();

        $this->photoName = $this->photo->getName();
        $this->photo->saveToDisc();
      }

      $db_conn = Database::getConnection();
      $params = array($this->name, $this->description, $this->price, $this->photoName ,$this->feactured, $this->stock, $this->departmentId, $this->id);
      $sql = "update products set name=$1, description=$2, price=$3, photoName=$4, feactured=$5, stock=$6, departmentId=$7 where id = $8";
      $resp = pg_query_params($db_conn, $sql, $params);
      
      pg_close($db_conn);
      return $resp;
    }
  }
?>