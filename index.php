<?php
date_default_timezone_set('Europe/London');

include ("D:/laragon-6.0.0/www/login/smarty3/Smarty.class.php");

session_start();

class Page{
    public $smarty;
    private $page = "index";
    private $db;
    public $message;
    public $error;

    function __construct(){
        $this->initSmarty();
        $this->initDB();
        $this->handleInputs($_REQUEST);
        $this->mainDisplay();         
    }

    function mainDisplay(){
        $this->smarty->assign("message",$this->message);
        $this->smarty->assign("error",$this->error);
        $this->smarty->display("header.tpl");
        $this->smarty->display($this->page.".tpl");
        $this->smarty->display("footer.tpl");
    }

    function initSmarty(){
        $this->smarty= new Smarty();
        $this->smarty->setTemplateDir('tpl');
        $this->smarty->setCompileDir('tpl/templates_c');
        $this->smarty->setCacheDir('tpl/cache');
        $this->smarty->setConfigDir('tpl/configs');        
    }

    private function handleInputs($requestData){
        if($requestData){
            if(isset($requestData['page'])){
                $this->page = $requestData['page'];
            }

            if(isset($requestData['uname']) && isset($requestData['pword'])){
                $this->tryLogin($requestData['uname'],$requestData['pword']);
            }

            if(isset($requestData['new-uname']) && isset($requestData['new-pword'])){
                $user = $this->checkUser($requestData['new-uname'],$requestData['new-pword']); 
                if($user){
                    $this->error = "That user already exists";
                } else {
                    $success = $this->createUser($requestData['new-uname'],$requestData['new-pword']);
                    if($success){
                        $this->message = "Account created";
                        $this->tryLogin($requestData['new-uname'],$requestData['new-pword']);
                    } else {
                        $this->error = "Error! Unable to create account, please try again";
                    }
                    
                }

            }

            if(isset($_GET['debugDB'])){
                $res = $this->db -> query('select * from users');

                while($line = $res->fetch()){
                    echo "<pre>".print_r($line,true)."</pre>";
                }
                die();
            }
        }  
    }


    private function checkUser($username, $password){
        $data = $this->db->query("SELECT * FROM users WHERE username='".$username."' AND password='".md5($password)."'");
        //return $data->fetch_assoc();//
        if(!$data){
            die("Can't find users table in database");
        }
        return $data->fetch();
    }

    private function createUser($username, $password){
        $sql = "INSERT INTO users (username, password) VALUES ('".$username."', '".md5($password)."')";
        $result = $this->db->query($sql);
        //print_r($result);
        //die("here");
        if ($result == TRUE) {
            return true;
          } 
        return false;
    }

    private function initDB(){
        //$this->db = new mysqli("localhost", "root", "", "test");//
        //$this->db = new PDO("sqlite:User_db.db");//

//TODO::check if the file exists. If not, re-create it
        if(file_exists('User_db.db')){
            $this->db = new PDO("sqlite:User_db.db");
        }else{
            $this->createDB('User_db.db');
        }

        if(!$this->db){
            die("Error creating database connection");
        }
    }

    private function createDB($file){
        $this->db = new PDO("sqlite:".$file);
        $this->db -> exec('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username varchar35, password varchar35, access number DEFAULT 1)');
        //print ("Table users created");
        //$res = $db -> query('select * from users');
        //echo print_r($res);

    }

    private function tryLogin($username, $password){
        $user = $this->checkUser($username,$password); 
        if($user){
            $_SESSION['user'] = $user;
        }  
    }

    
}
    new Page;
?>