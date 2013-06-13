<?php
	class ProductsController extends BaseController {
		
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
	
	}
?>