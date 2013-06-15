<?php
	class ProductsController extends BaseController {
		
<<<<<<< HEAD
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
=======
		function index (){
			$products= Product::getAllByPage(5, 1);
    		$this->render(array('view' => 'products/index.phtml', 'products' => $products));
  		}
		
		function category($id) {
			$ret= Product::findByDepartment($id);
			extract($ret);
			echo $numRows;
			
			$this->render(array('view' => 'products/index.phtml', 'products' => $products, 'numRows' => $numRows));
			
		}
>>>>>>> 4a2c7dbcf665f2b6970f803f511d403e5076e772
	
	}
?>