<?php

function should_be_autenticated(){
  if (!(isset($_SESSION['user']))) {
    flash('error', 'Você deve estar logado para acessar está página!');
    redirect_to('/sessions/new.phtml');
    exit;
  }
}

function should_not_be_autenticated(){
  if (isset($_SESSION['user'])) {
    flash('warning', 'Você deve estar deslogado para acessar está página!');
    redirect_to('/');
    exit;
  }
}

function should_be_autenticated_as_admin() {
  should_be_autenticated();
  if (!current_user()->getAdmin()) {
    flash('error', 'Você não tem permissão para acessar a página solicitada!');
    redirect_to(back());
    exit;
  }
}

/**
* Quando chamada sem o parâmetro, retorna verdadeiro se existir um usuário
* logado, caso contrário falso.
*
* Quanto chamada com o parâmetro, retorna o atributo do usuário logado,
* se o mesmo existir.
*/
function current_user() {
  if (isset($_SESSION['user'])) {
    return User::findById($_SESSION['user']['id']);
  } else
  return false;
}

?>