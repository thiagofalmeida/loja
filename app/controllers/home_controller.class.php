<?php
	class HomeController  extends BaseController {
		function index(){
			$products = Product::getFeacturedProducts();

    		$this->render(array('view' => 'home/index.phtml', 'products' => $products));
  		}
	}
?>