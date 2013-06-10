<?php
class UsersController extends BaseController {
	
	function start() {
		$this->render(array('view' => 'users/start.phtml'));
	}

	function common() {
		$this->render(array('view' => 'users/common.phtml', 'common' => new Common()));
	}

	function company() {
		$this->render(array('view' => 'users/company.phtml', 'company' => new Company()));
	}

	function createCommon() {
		$common = new Common($_POST['common']);
		
		if ($common->save()) {
			flash('success', 'Registro realizado com sucesso!');
			redirect_to('/login');
		} else {
			flash('error', 'Existe dados incorretos no seu formulário!');
			$this->render(array('view' => 'users/common.phtml', 'common' => $common));
		}
	}

	function createCompany() {
		$company = new Company($_POST['company']);
		
		if ($company->save()) {
			flash('success', 'Registro realizado com sucesso!');
			redirect_to('/login');
		} else {
			flash('error', 'Existe dados incorretos no seu formulário!');
			$this->render(array('view' => 'users/company.phtml', 'company' => $company));
		}
	}
}
?>