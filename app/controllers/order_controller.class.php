<?php
	class OrderController extends BaseController {
		
		public function index (){
			
  		}
		
		public function create() {
			$products = CART::getProducts();	
			echo $products[5];
		}
		
	
	}
?>