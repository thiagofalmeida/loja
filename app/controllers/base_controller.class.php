<?php
abstract class BaseController {

    public function render($datas) {
    	extract($datas);
    	if (current_user()) { 
    		if (current_user()->getAdmin())  {
    			require 'views/admin/layout/header.inc.phtml';	
    		}
			else {
    			require 'views/layout/header.inc.phtml';
    		}
    	} else {
    		require 'views/layout/header.inc.phtml';
    	}
    	require 'views/' . $view;
    	require 'views/layout/footer.inc.phtml';
    	exit();
  	}
}
?>