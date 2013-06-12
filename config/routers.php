<?php
    require 'application.php';

    Logger::getInstance()->log($_SERVER['REQUEST_URI'], Logger::NOTICE);

    $url = new FriendlyURL();


    switch ($url->params(0)) {
        case '':
            $controller = new HomeController();
            $controller->index();
        break;

        case 'fale-conosco':
            switch ($url->numberOfParams()) {
                case 1:
                    $controller = new ContactController();
                    $controller->_new();
                case 2:
                    if ($url->params(1) == 'enviar'){
                        redirect_if_not_a_post_request('contact');
                        $controller = new ContactController();
                        $controller->send();
                    }
                break;
                default:
                    page_not_found();
            }
        break;

        case 'admin':
            should_be_autenticated_as_admin();
            switch ($url->params(1)) {
                case '':
                    $controller = new Admin\HomeController();
                    $controller->index();
                break;

                 case 'produtos':
                   $controller = new Admin\ProductController();
                   resources($controller, $url->paramsAfter(2));
                break;
                
                case 'mensagens':
                    $controller = new Admin\ContactController();
                    $controller->show();
                break;

                case 'departamentos':
                    $controller = new Admin\DepartmentController();
                    resources($controller, $url->paramsAfter(2));
                break;

                default:
                    page_not_found();
            }
        break;

        case 'login':
            switch ($url->numberOfParams()) {
                case 1:
                    $controller = new SessionsController();
                    if ($_SERVER['REQUEST_METHOD'] == 'POST')
                        $controller->create();
                    else
                        $controller->_new();
                break;
                default:
                    page_not_found();
                }
        break;

        case 'logout':
            switch ($url->numberOfParams()) {
                case 1:
                    $controller = new SessionsController();
                    $controller->destroy();
                break;
                default:
                    page_not_found();
            }
        break;

        case 'sobre-a-empresa':
            switch ($url->numberOfParams()) {
                case 1:
                    $controller = new AboutController();
                    $controller->_new();
                break;
                default:
                    page_not_found();
            }
        break;

        case 'registre-se':
            switch ($url->numberOfParams()) {
                case 1:
                    $controller = new UsersController();
                    $controller->start();
                case 2:
                    if ($url->params(1) == 'pessoa'){
                        if ($_POST['user'] == 'common'){
                            $controller = new UsersController();
                            $controller->common();
                        } else {
                            $controller = new UsersController();
                            $controller->company();
                        }
                    } 
                
                case 3:
                    if ($url->params(1) == 'pessoa-fisica') {
                        $controller = new UsersController();
                        $controller->createCommon(); 
                    } else if ($url->params(1) == 'pessoa-juridica') {
                        $controller = new UsersController();
                        $controller->createCompany(); 
                    } else {
                        page_not_found();
                    }
                break;
            
                default:
                    page_not_found();
            }
        break;

        case 'produtos':
            switch ($url->numberOfParams()) {
                case 1:
                    $controller = new ProductsController();
                    $controller->index();
                break;
                default:
                    page_not_found();
            }
        break;

        default:
            page_not_found();
    }

    function resources($controller, $params){
        switch (sizeof($params)) {
            case 0:
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {      # POST /registros
                    $controller->create();
                } else {                                         # GET /registros
                    $controller->index();
                }
            break;
    
            case 1:
                if ($params[0] == 'novo') {
                    $controller->_new();
                } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->save($params[0]);
                } else {
                    $controller->show($params[0]);
                }
            break;
        
            case 2:
                if ($params[1] == 'editar') { # GET /registros/id/editar
                    $controller->edit($params[0]);
                } else if ($params[1] == 'deletar') { # GET /registros/id/deletar
                    $controller->destroy($params[0]);
                } else 
                    page_not_found();
            break;
            default:
                page_not_found();
        }
    }

   /*-----------------------------------------------------------------------*/
   /* Informa que a página não foi encontrada e redireciona para o root da aplicação */
   function page_not_found(){
      Logger::getInstance()->log("URL NOT FOUND: " . $_SERVER['REQUEST_URI'], Logger::ERROR);
      flash('error', 'Página não encontrada!');
      redirect_to('/');
   }
?>