<?php
	namespace Admin;

	class ProductController extends \BaseController {

  		function index() {
			$product = \Product::getAll();
			$this->render(array('view' => 'admin/products/index.phtml','products' => $product));
		}

		function _new(){
			$department = \Department::getAll();	
			$this->render(array('view' => 'admin/products/new.phtml', 'product' => new \Product(), 'departments' => $department));	
		}

		function show($id){
			$product = \Product::findById($id);

			if ($product === null) {
				flash('error', 'Produto não encontrado');
				redirect_to('/');
			}
			
			$this->render(array('view' => 'admin/products/show.phtml', 'product' => $product));
		}

		public function edit($id){
			$product = \Product::findById($id);
			$department = \Department::getAll();

			if ($product === null) {
				flash('error', 'Produto não encontrado');
				redirect_to('/');
			}

			$this->render(array('view' => 'admin/products/edit.phtml', 'product' => $product, 'departments' => $department));
		}

		function destroy($id){
			$product = \Product::findById($id);
			$product->delete();
			flash('success', 'Produto deletado com sucesso!');
			redirect_to("/admin/produtos");
		}

		public function create(){
			$product = new \Product($_POST['product']);
			$photo = new \Photo($_FILES['product_photo'], 'products');
			$product->setFeactured(isset($_POST['product']['feactured']) ? 't' : 'f');

			$product->setDepartment_Id($_POST['department']);
			$product->setPhoto($photo);

			if ($product->save()) {
				flash('success', 'Produto cadastrado com sucesso!');
				redirect_to('/admin/produtos');
			} else {
				flash('error', 'Existe dados incorretos no seu formulário!');
				$department = \Department::getAll();
				$this->render(array('view' => 'admin/products/new.phtml', 'product' => $product, 'departments' => $department));
			}
		}

		public function save($id){
			$product = \Product::findById($id);
			$product->setName($_POST['product']['name']);
			$product->setDescription($_POST['product']['description']);
			$product->setStock($_POST['product']['stock']);
			$product->setFeactured(isset($_POST['product']['feactured']) ? 't' : 'f');
			$product->setPrice($_POST['product']['price']);
			$product->setDepartment_Id($_POST['department']);
		
			$photo = new \Photo($_FILES['product_photo'], 'products');
			$product->setPhoto($photo);

			$department = \Department::getAll();

			if ($product->update()) {
				flash('success', 'Produto atualizado com sucesso!');
				redirect_to("/admin/produtos/{$product->getId()}");
			}else{
				flash('error', 'Existe dados incorretos no seu formulário!');
				$this->render(array('view' => 'admin/products/edit.phtml', 'product' => $product, 'departments' => $department));
			}
		}
	}
?>