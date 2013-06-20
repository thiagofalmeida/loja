<?php
	function boolean_convert($bool) {
		if ($bool)
			return 'Sim';

		return 'Não';
	}

	function money_convert($value) {
		return number_format($value , 2, ',', '.');
	}
?>