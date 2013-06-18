<?php
class SessionsController extends BaseController {
	public function _new() {
		$this->render(array('view' => 'sessions/new.phtml'));
	}

	public function create() {
		$session = new UserSession($_POST['user']);

		if ($session->wasCreate()) {
			flash('success', 'Login realizado com sucesso!');
			
			if (current_user()->getAdmin()) {
				$this->render(array('view' => 'admin/home/index.phtml'));
			} else {
				$this->render(array('view' => 'home/index.phtml'));
			}
		} else {
			flash('error', 'Login/senha incorretas!');
			$this->render(array('view' => 'sessions/new.phtml'));
		}
	}

	public function destroy() {
		$session = new UserSession();
		$session->destroy();
		redirect_to('/');
	}
}
?>