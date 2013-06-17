<?php
	namespace Admin;

	class HomeController  extends \BaseController {
		function index(){
    		$this->render(array('view' => 'admin/home/index.phtml'));
  		}
	}
?>