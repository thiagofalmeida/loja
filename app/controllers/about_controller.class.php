<?php
	class AboutController  extends BaseController {
		function _new(){
    		$this->render(array('view' => 'about/new.phtml'));
  		}
	}
?>