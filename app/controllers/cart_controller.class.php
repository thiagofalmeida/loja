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
			if (isset($_SESSION['flash'])) {
				redirect_to(back());
			} else {
				flash('error', 'Não foi possivel adicionar o item ao carrinho');
			}
			
		}
		redirect_to(back());
	}

	function close($id) {
		$cart = new Cart();

		if ($cart->add($id)) {
			flash('success', 'Item adicionado ao carrinho com sucesso');
			redirect_to('/carrinho');
		} else {
			if (isset($_SESSION['flash'])) {
				redirect_to(back());
			} else {
				flash('error', 'Não foi possivel adicionar o item ao carrinho');
			}
			redirect_to(back());
		}
	}

	function update() {
		$cart = new Cart(); 

		if (!empty($_POST['amount'])) {
			foreach ($_POST['amount'] as $id => $qnt) {
				if (Product::getStockById($id) <= $qnt){
					flash('error', 'Não foi possivel adicionar ' . $qnt . ' unidades do item ' . $id . ' ao carrinho pois não há estoque suficiente');
				} else {
					$cart->setItemQuantity($id, $qnt);
					flash('success', 'Carrinho atualizado com sucesso!');
				}
			}
			redirect_to(back());
		}

		if(!empty($_POST['remove'])) {
			foreach ( $_POST['remove'] as $id ) { 
				$cart->setItemQuantity($id, 0);
			}
			flash('success', 'Item removido com sucesso!');    
		}

  		redirect_to(back());
	}
}
?>