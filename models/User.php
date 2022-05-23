<?php 
class User{
    private $db; 
    public $username; 
    public $password;
    function __construct($db){
        $this->db = $db; 
    }
    function start_session(){
        if(!headers_sent() && empty(session_id())){
            session_start();
        }
    }
    public function login(){
        $query = $this->db->query("SELECT 
            id, user_type_id FROM reg_db 
            WHERE username = '$this->username'
            AND reg_db.password = '$this->password'");
        $user = mysqli_fetch_assoc($query);
        if(!empty($user)){
            $this->set_session("userId", $user['id']);
            $this->set_session("user_type", $user['user_type_id']);
            return $user['user_type_id'];
        }else{
            return 0;
        }
    }
    public function set_session($key, $val){
        $this->start_session();
        return $_SESSION[$key] = $val;
    }
    public function get_session($key){
        $this->start_session();
        return $_SESSION[$key];
    }
    public function display_errors($errors){
        $display = '<ul class="bg-danger">';
        foreach ($errors as $error) {
          $display .='<li style="color: white;">'.$error.'</li>';
        }
        $display .='</ul>';
        return $display;
    }
}
?>