<?php
  define('APP_NAME', 'loja' );
  define('SITE_ROOT', '/loja' ); # com barras
  define('APP_ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '' . SITE_ROOT );

  define('ASSETS_FOLDER', SITE_ROOT .  '/app/assets');
  define('LOG_FILE', APP_ROOT_FOLDER .  '/logs/logger.log');

  /* Adicionar pastas defaults para inclução de arquivos com as funções require e include */
  set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER );
  set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER  . '/config/');
  set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER  . '/app');
  set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER  . '/lib/');
  set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER  . '/vendor/');

  session_start();

  date_default_timezone_set('America/Sao_Paulo');

  require_once 'auto_load_classes.php';
  require_once 'flash_message.php';
  require_once 'links_functions.php';
  require_once 'sessions_functions.php';
  require_once 'php_logger/logger.class.php';
  require_once 'utils_functions.php';

  Logger::getInstance()->loadFile(LOG_FILE);
?>