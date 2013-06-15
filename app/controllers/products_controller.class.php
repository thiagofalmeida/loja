<?php
	class ProductsController extends BaseController {
		
		function index() {
			$products= Product::getAll();
    		$this->render(array('view' => 'products/index.phtml', 'products' => $products));
  		}

  		function details() {
			$id = 26;
			$product = Product::findById($id);

			if ($product === null) {
				flash('error', 'Produto não encontrado');
				redirect_to('/');
			}
			
			$this->render(array('view' => 'products/details.phtml', 'product' => $product));
  		}
	
	}
?>