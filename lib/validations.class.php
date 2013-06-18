<?php 
class Validations {
  public static function notEmpty($value, $key = null, &$errors = null){
    if (empty($value)){
      if ($key !== null && $errors !== null) {
        $msg = 'não deve ser vazio';
        $errors[$key] = $msg;
      }
      return false;
    }
    return true;
  }

  public static function validEmail($email, $key = null, &$errors = null){
    $pattern = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+/';

    if (preg_match($pattern, $email))
      return true;

    if ($key !== null && $errors !== null)
      $errors[$key] = 'não é válido';

    return false;
  }
                                                                                                
  public static function uniqueField($value, $field, $table, $key = null, &$errors = null) {
    $sql = "select {$field} from {$table} where {$field} = $1";
    $resp = pg_query_params(Database::getConnection(), $sql, array($value));
     
    if (pg_affected_rows($resp) > 0) {
      $msg = 'já existe um cadastro com esse dado';
      $errors[$key] = $msg;
      return false;
    }
    return true;
  }

  public static function validDate($dtnasc, $key = null, &$errors = null) {
    $pattern = '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/';
  
    if (preg_match($pattern, $dtnasc))
      return true;

    if ($key !== null && $errors !== null) 
      $errors[$key] = 'não é válido';

    return false;
  }


  public static function validPhone($phone, $key = null, &$errors = null) {
    $pattern = '/^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$/';
  
    if (preg_match($pattern, $phone))
      return true;

    if ($key !== null && $errors !== null) 
      $errors[$key] = 'não é válido';

    return false;
  }

  public static function validCpf($cpf, $key = null, &$errors = null) {
    $pattern = '/^[0-9]{3}.[0-9]{3}.[0-9]{3}\-[0-9]{2}$/';
  
    if (preg_match($pattern, $cpf))
      return true;

    if ($key !== null && $errors !== null) 
      $errors[$key] = 'não é válido';

    return false;
  }

  public static function validCnpj($cnpj, $key = null, &$errors = null) {
    $pattern = '/^[0-9]{2}.[0-9]{3}.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/';
  
    if (preg_match($pattern, $cnpj))
      return true;

    if ($key !== null && $errors !== null) 
      $errors[$key] = 'não é válido';

    return false;
  }

  public static function validCep($cep, $key = null, &$errors = null) {
    $pattern = '/^[0-9]{5}-[0-9]{3}$/';
  
    if (preg_match($pattern, $cep))
      return true;

    if ($key !== null && $errors !== null) 
      $errors[$key] = 'não é válido';

    return false;
  }

  public static function notANumber($value, $key = null, &$errors = null) {
    if (!is_numeric($value)) {
      if ($key !== null && $errors !== null) {
        $msg = 'não pode ser letras ou caracteres especiais';
        $errors[$key] = $msg;
      }
      return false;
    }
    return true;
  }
}
?>