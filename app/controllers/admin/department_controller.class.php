<?php 
	namespace Admin;
	
	class DepartmentController extends \BaseController {
	
		public function _new(){
			$this->render(array('view' => 'admin/departments/new.phtml', 'department' => new \Department()));	
		}

		public function create(){
			$department = new \Department($_POST['department']);

			if ($department->save()) {
				flash('success', 'Departamento cadastrado com sucesso!');
				redirect_to('/admin/departamentos');
			} else {
				flash('error', 'Existe dados incorretos no seu formulário!');
				$this->render(array('view' => 'admin/departments/new.phtml','department' => $department));
			}
		}

		public function index() {
			$department = \Department::getAll();
			$this->render(array('view' => 'admin/departments/index.phtml','departments' => $department));
		}

		public function show($id){
			$department = \Department::findById($id);

			if ($department === null) {
				flash('error', 'Departamento não encontrado');
				redirect_to('/');
			}
			
			$this->render(array('view' => 'admin/departments/show.phtml', 'department' => $department));
		}

		public function edit($id){
			$department = \Department::findById($id);

			if ($department === null) {
				flash('error', 'Departamento não encontrado');
				redirect_to('/');
			}

			$this->render(array('view' => 'admin/departments/edit.phtml', 'department' => $department));
		}

		public function destroy($id){
			$department = \Department::findById($id);
			$department->delete();
			flash('success', 'Departamento deletado com sucesso!');
			redirect_to("/admin/departamentos");
		}

		public function save($id){
			$department = \Department::findById($id);
			$department->setName($_POST['department']['name']);

			if ($department->update()) {
				flash('success', 'Departamento atualizado com sucesso!');
				redirect_to("/admin/departamentos/{$department->getId()}");
			} else {
				flash('error', 'Existe dados incorretos no seu formulário!');
				$this->render(array('view' => 'admin/departments/edit.phtml', 'department' => $department));
			}
		}

	}
?>