<?php
  /*
   * Função autoload é utilizada para carregar automaticamente as classes quando elas forem utilizadas
   */
  function __autoload($class_name) {
    # from camel case to snack case
    $class_name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $class_name));
    $class_name = str_replace('\\', '/', $class_name);

    $file = APP_ROOT_FOLDER . '/app/models/' . strtolower($class_name) . '.class.php';

    if (file_exists($file) == true)
      return require_once $file;
    else{
      $file = APP_ROOT_FOLDER . '/lib/' . $class_name . '.class.php';

      if (file_exists($file) == true)
        return require_once $file;
      else {
        $file = APP_ROOT_FOLDER . '/app/controllers/' . $class_name . '.class.php';
        if (file_exists($file) == true)
          return require_once $file;
        else
          return false;
      }
      return false;
    }
  }
?>