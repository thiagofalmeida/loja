<?php 
	namespace Admin;
	class ContactController extends \BaseController {
	
	public function show() {
		$this->render(array('view' => 'admin/contacts/show.phtml'));
	}
}
?>