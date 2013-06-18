<?php
	class ProductsController extends BaseController {
		
		/*unction index() {
			$products= Product::getAll();
    		$this->render(array('view' => 'products/index.phtml', 'products' => $products));
  		}*/

  		function details() {
			$id = 51;
			$product = Product::findById($id);

			if ($product === null) {
				flash('error', 'Produto não encontrado');
				redirect_to('/');
			}
			
			$this->render(array('view' => 'products/details.phtml', 'product' => $product));
  		}

		function index (){
			$products = Product::getAllByPage(5, 1);
    		$this->render(array('view' => 'products/index.phtml', 'products' => $products));
  		}
		
		function getById($id) {
			$product = Product::findById($id);
			$this->render(array('view' => 'products/details.phtml', 'product' => $product));
		}
		
		function category($id) {
			$ret= Product::findByDepartment($id);
			extract($ret);
			$this->render(array('view' => 'products/index.phtml', 'products' => $products, 'numRows' => $numRows));
		}
	}
?>