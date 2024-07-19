<?php
//session class to manage our login system

class Session
{
    private $signed_in = false;
    public $user_id;
    public $message;
    public $count;


    //1-construct method to start session automatically
    function __construct()
    {
        session_start();
        //also call check_the_login() method in the contruct to apply automatically
        $this->check_the_login();
        //also call check_message() method in the contruct to apply automatically
        $this->check_message();
        //also call visitor_count() method in the contruct to apply automatically
        $this->visitor_count();
    }

    //function to count how much there is users enter the page\
    //note: every reffresh it count and when navigate with pages it will count also 
    public function visitor_count()
    {
        if (isset($_SESSION['count'])) {
            return $this->count = $_SESSION['count']++;
        } else {
            return $_SESSION['count'] = 1;
        }
    }

    //getter method to get a private value from the class to using it to check if the user is logged in or not 
    public function is_signed_in()
    {
        //basically we put default value for ($signed_in) as a false
        //so if it still false so user not signed in but if some method change the value for true so user signed in
        //so we can call this method any where to check if user signed in or not
        //and this method getting a private property value so this call a getter method
        return $this->signed_in;
    }

    //method to print message
    public function message($msg = "")
    {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    //method to check if there is message in _SESSION
    public function check_message()
    {
        if (isset($_SESSION['message'])) {
            //if there is message in _SESSION we will grap it to message property
            $this->message = $_SESSION['message'];
            //then unset again because if user reffresh the page message have to gone
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    //method to login the user
    public function login($user)
    {
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id; //(id) from User class
            $this->signed_in = true;
        }
    }

    //method to logout user
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    //2-method to chick if the session user_id is set (isset)
    private function check_the_login()
    {
        if (isset($_SESSION['user_id'])) {
            //if is set then we will apply session value to user_id property
            $this->user_id = $_SESSION['user_id'];
            //and make $signed_in true because we will use it to check if user is logged in or not
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
}

$session = new Session();
$message = $session->message();
