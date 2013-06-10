<?php
	class HomeController  extends BaseController {
		function index(){
    		$this->render(array('view' => 'home/index.phtml'));
  		}
	}
?>