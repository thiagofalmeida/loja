<?php
class CartController  extends BaseController {
	function index() {
		$cart = Cart::getProducts();
		$this->render(array('view' => 'cart/index.phtml', 'cart' => $cart));
	}

	function add($id) {
		$cart = new Cart();

		if ($cart->add($id)) {
			flash('success', 'Item adicionado ao carrinho com sucesso');
		} else {
			flash('error', 'Não foi possivel adicionar o item ao carrinho');
		}
		redirect_to(back());
	}

	function update() {
		$cart = new Cart();  

		if(!empty($_POST['amount'])) {  
			foreach ($_POST['amount'] as $cod => $amount) {  
				$cart->setItemQuantity($cod, $amount);
			} 
			flash('success', 'Quantidade alterada com sucesso!');  
		}

		if(!empty($_POST['remove'])) {
			foreach ( $_POST['remove'] as $cod ) { 
				$cart->setItemQuantity($cod, 0);
			}
			flash('success', 'Item removido com sucesso!');    
		}

  		redirect_to(back());
	}
}
?>