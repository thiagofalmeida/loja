<?php
class ContactController extends BaseController {

  public function _new() {
    $contact = new Contact();
    $this->render(array('view' => 'contacts/new.phtml', 'contact' => $contact));
  }

  public function send() {
    $contact = new Contact($_POST['contact']);

    if ($contact->save()) {
      flash('success', 'Mensagem enviada com sucesso!');
      redirect_to('/');
    } else {
      flash('error', 'Existe dados incorretos no seu formulário!');
      $this->render(array('view' => 'contacts/new.phtml', 'contact' => $contact));
    }
  }
}
?>