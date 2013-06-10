<?php
	class ProductsController extends BaseController {
		function show(){
    		$this->render(array('view' => 'products/index.phtml'));
  		}
	}
?>