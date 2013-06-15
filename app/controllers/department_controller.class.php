<?php
	class DepartmentController extends BaseController {
		
		public function index ($id){
			$products=Product::findByDepartment($id);
			if (sizeof($products)==0) {
				flash('error', 'Categoria não encontrada');
				redirect_to('/');
			}
    		$this->render(array('view' => 'department/index.phtml', 'products' => $products));
  		}
		
	
	}
?>