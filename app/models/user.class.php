<?php 
class User extends Base {

    protected $email;
    protected $password;
    protected $admin;

    public function validates() {}
    
    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    public function getAdmin() {
        return $this->admin == 't';
    }

    public static function findById($id){
        $db_conn = Database::getConnection();
        $sql = "select * from users where id = $1;";
        $params = array($id);
        $resp = pg_query_params($db_conn, $sql, $params);

        if (!$resp) {
          pg_close($db_conn); 
          return null; 
        }

        if ($row = pg_fetch_assoc($resp)) {
            $user = new User($row);
            pg_close($db_conn);
            return $user;
        }
    
        pg_close($db_conn);
        return null;
    }
}
?>