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

var data_confirm = function () {
   $('a[data-confirm]').click( function () {
      var msg = $(this).data('confirm');
      return confirm(msg);
   });
};

jQuery(function($) {
    $("#common_phone").mask("(99)9999-9999");
    $("#common_dtnasc").mask("99/99/9999");
    $('#common_cpf').mask('999.999.999-99');
    $('#user_cep').mask('99999-999');
    $('#company_phone').mask('(99)9999-9999');
    $('#company_cnpj').mask('99.999.999/9999-99');
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

  $('#gallery a').lightBox({fixedNavigation:true}); 
  $('.jqzoom').jqzoom({ zoomType : 'reverse' });
});

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk')
);