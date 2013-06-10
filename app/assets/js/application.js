function search_address() {
	// Se o campo CEP não estiver vazio
	if($.trim($("#user_cep").val()) !== "") { 
	  	$.getScript("http://republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#user_cep").val(), function(){
			if(resultadoCEP["resultado"] && resultadoCEP[""] !== "") {
				// troca o valor dos elementos
				$("#street").val(unescape(resultadoCEP["tipo_logradouro"]) + ": " + unescape(resultadoCEP["logradouro"]));
				$("#neighboorhood").val(unescape(resultadoCEP["bairro"]));
				$("#city").val(unescape(resultadoCEP["cidade"]));
				$("#state").val(unescape(resultadoCEP["uf"]));
				$("#num").focus();
			} else {
				alert("Endereço não encontrado");
				return false;
			}
		});                             
	} else {
      alert('Antes, preencha o campo CEP!');
   }
}

jQuery(function($) {
	$('#common_cpf').mask('999.999.999-42');
});

$(document).ready(function() {
   data_confirm();

   $(this).scroll(function() {
      if ($(this).scrollTop() > 130){
        $('.sidebar-nav').addClass('sidebar-nav-fixed');
      } else {
        $('.sidebar-nav').removeClass('sidebar-nav-fixed');
      }
   });
});