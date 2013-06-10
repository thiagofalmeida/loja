<?php
abstract class BaseController {

    public function render($datas) {
    	extract($datas);
    	require 'views/layout/header.inc.phtml';
    	require 'views/' . $view;
    	require 'views/layout/footer.inc.phtml';
    	exit();
  	}
}
?>