<?php
class UserSession extends Base {
	private $email;
	private $password;
	
	public function setEmail($email) {
		$this->email = $email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function validates() {
		
	}

	public function wasCreate() {
		$db_conn = Database::getConnection();
		$sql = "select id from users where email = $1 and password = $2";
		$params = array($this->email, sha1($this->password));
		$resp = pg_query_params($db_conn, $sql, $params);

		if ($resp && $user = pg_fetch_assoc($resp)) {
			$_SESSION['user']['id'] = $user['id'];
			//Logger::getInstance()->log("Usuário: {$user[id]} logou no sistema", Logger::NOTICE);
			pg_close($db_conn);
			return true;
		}

		Logger::getInstance()->log("Login:" . print_r(error_get_last(), true), Logger::ERROR);
		pg_close($db_conn);
		return false;
	}

	public function destroy() {
		//Logger::getInstance()->log("Usuário: {$user[id]} deslogou no sistema", Logger::NOTICE);
		unset($_SESSION['user']);
	}
}
?>