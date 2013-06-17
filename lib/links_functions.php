<?php
  /*
   * Funções destinadas a criação de urls
   * Importante, pois com elas não é necessário fazer diversas
   * alterações quando mudar a url principal do site
   */

  function url_for($path){
    return SITE_ROOT . $path;
  }

  function link_to($path, $name, $options = '') {
    if (substr($path, 0, 1) == '/')
       $link = SITE_ROOT . $path;
     else
       $link = $path;
    return "<a href='{$link}' {$options}> $name </a>";
  }

  function button_to($path, $name, $class = '') {
    if (substr($path, 0, 1) == '/')
       $link = SITE_ROOT . $path;
     else
       $link = $path;
    return "<a href='{$link}' class='{$class}'> $name </a>";
  }  

  function stylesheet_include_tag() {
     $params = func_get_args();
     foreach($params as $param){
       $path = ASSETS_FOLDER . "/css/" . $param;
       echo "<link href='{$path}' rel='stylesheet' type='text/css' />";
     }
  }

  function javascript_include_tag(){
    $params = func_get_args();
    foreach($params as $param){
      $path = ASSETS_FOLDER . '/js/' . $param;
      echo "<script language='JavaScript' src='{$path}' type='text/JavaScript'></script>";
    }
  }

  function image_link($for, $type, $file){
  	return  SITE_ROOT . '/app/assets/img/photos/' . $for . '/' . $type . '/' . $file;
  }
  
  function image_tag($for, $type, $file, $name){
    return '<img src="' . SITE_ROOT . '/app/assets/img/photos/' . $for . '/' . $type . '/' . $file . '" alt="' . $name . '" />';
  }

    /*=================================================*/
  /*
   * Funções destinadas a redirecionamento de páginas
   * Lembre-se que quando um endereço inicia-se com '/' diz respeito
   * a um caminho absoluto, caso contrário é um caminho relativo.
  */
  function redirect_to($address) {
    if (substr($address, 0, 1) == '/')
      header('location: ' . SITE_ROOT . $address);
    else
      header('location: ' . $address);
  }

  /*
   * Retorna o endereço da última página carregada,
   * caso não exista retorna o endereço da página principal da aplicação
   */
  function back(){
    if (isset($_SERVER['HTTP_REFERER'])){
      return $_SERVER['HTTP_REFERER'];
    }else{
      return '/';
    }
  }

  function redirect_if_not_a_post_request() {
    $location = '/';
    $params = func_get_args();
    $last_element = isset($params[sizeof($params)-1]) ? $params[sizeof($params)-1] : '';

    if (strpos($last_element, 'location:') !== false)
      $location = array_pop($params);

    foreach($params as $param){
      if (!isset($_POST[$param])){
        redirect_to($location);
        exit();
      }
    }
  }
?>