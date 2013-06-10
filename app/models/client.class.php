<?php
class Client extends User {
  protected $cep;
  protected $street;
  protected $num;
  protected $neighboorhood;
  protected $city;
  protected $state;
  protected $phone;

  public function validates() {

  }

  public function setCep($cep){
    $this->cep = $cep;
  }

  public function getCep(){
    return $this->cep;
  }

  public function setStreet($street){
    $this->street = $street;
  }

  public function getStreet(){
    return $this->street;
  }  

  public function setState($state){
    $this->state = $state;
  }

  public function getState(){
    return $this->state;
  }

  public function setCity($city){
    $this->city = $city;
  }

  public function getCity(){
    return $this->city;
  }

  public function setNum($num){
    $this->num = $num;
  }

  public function getNum(){
    return $this->num;
  }

  public function setNeighboorhood($neighboorhood) {
    $this->neighboorhood = $neighboorhood;
  }

  public function getNeighboorhood() {
    return $this->neighboorhood;
  }

  public function setPhone($phone){
    $this->phone = $phone;
  }

  public function getPhone(){
    return $this->phone;
  }
}
?>