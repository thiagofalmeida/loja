<?php
/*
 * flash message
 * A variável flash permite armazenar mensagens durante apenas uma mudança de página.
 * Excelente para avisos e alertas
 */
function flash($key=null, $value = null) {
  if (isset($key)) {
    if (isset($value)){
      $_SESSION['flash'][$key] = $value;
    }else{
      $val = isset($_SESSION['flash'][$key]) ? $_SESSION['flash'][$key] :'';
      unset($_SESSION['flash'][$key]);
      return $val;
    }
  }else{
    $flashs = isset($_SESSION['flash']) ? $_SESSION['flash'] : array();
    unset($_SESSION['flash']);
    return $flashs;
  }
}
?>