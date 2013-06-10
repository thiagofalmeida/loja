<?php
  class FriendlyURL {
    private $params;

    public function __construct() {
      $this->initialize();
    }

    private function initialize(){
       # recupera a url solicitada
       $url = $_SERVER['REQUEST_URI'];
       # torna o root da aplicação com root da url
       # ex: /aulas/mvc/mvc_01/ para /
       $url = str_replace(SITE_ROOT, '', $url);

       # remove a última barra se ela existir
       if (substr($url, 0, 1) == '/') $url = substr($url, 1);

       # recupera todos as partes da url
       $this->params = explode('/', $url);
    }

    public function params($index) {
      if (isset($this->params[$index]))
        return $this->params[$index];
      return false;
    }

    public function numberOfParams(){
      return sizeof($this->params);
    }

    public function paramsAfter($index) {
      return array_slice($this->params, $index, $this->numberOfParams());
    }
  }
?>