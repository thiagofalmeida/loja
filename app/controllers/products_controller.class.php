<?php
	class ProductsController extends BaseController {
		
		function index (){
			$products= Product::getAll();
			
    		$this->render(array('view' => 'products/index.phtml', 'products' => $products));
  		}
	
	}
?>