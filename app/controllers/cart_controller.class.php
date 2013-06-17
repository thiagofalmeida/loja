<?php
	class CartController  extends BaseController {
		function index() {
			$cart = Cart::getProducts();
    		$this->render(array('view' => 'cart/index.phtml', 'cart' => $cart));
  		}

  		function add($id) {
			$cart = new Cart();
			$id = (int)$id;
			
			if ($cart->add($id)) {
				flash('success', 'Item adicionado ao carrinho com sucesso');
			} else {
				flash('error', 'Não foi possivel adicionar o item ao carrinho');
			}
			redirect_to(back());
  		}
	}
?>