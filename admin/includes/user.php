<?php


//will make the user class extend from db_object(will put in this class the method 
//that we will use it univesality(for multiple tables like get_all() method)) to inherent the method and property from it
//so previously we was have these methods in the user class but we want to make this methods universal 
//so we make another class to handle these methods
//بالمختصر الميثود اللي بنستخدمها بشكل شائع بغض النظر عن الكلاس اللي هية فيه بدنا ننقلهم على الكلاس الجديد
// ونعمل اكستند من هضاك الكلاس وهاض الاشي يسمى انهيرتنس وهاض الاشي بسهل علينا بدل ما نضل نعمل نسخ ولصق
// inheritence
class User extends Db_object
{
    // (abstracting tables) this abstraction property
    protected static $db_table = "users";
    //array to save db_table keys to use it with abstraction methods
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'filename');

    //properties to easily get the user information from database (must be based on your coulmns in database table)
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $filename;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/400x400&text=image";


    //method to verify if user in database or not   
    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE ";
        $sql .= "username='{$username}' ";
        $sql .= "AND password='{$password}' ";
        $sql .= "LIMIT 1";
        $the_result_array = self::find_this_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }


    public function image_path_and_placeholder()
    {
        return empty($this->filename) ? $this->image_placeholder : $this->upload_directory . DS . $this->filename;
    }

    public function upload_user_photo()
    {
        if (!empty($this->custom_errors)) {
            return false;
        }

        if (empty($this->filename) || empty($this->tmp_path)) {
            $this->custom_errors[] = "the file was not available";
            return false;
        }
        //the path for the uploaded file 
        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;
        //check if the file exist or not 
        if (file_exists($target_path)) {
            $this->custom_errors[] = "this file {$this->filename} already exist";
            return false;
        }
        //The move_uploaded_file() function moves an uploaded file to a new destination.and it take two parameter 
        //1-file:Specifies the filename of the uploaded file
        //2-destination:Specifies the new location for the file
        if (move_uploaded_file($this->tmp_path, $target_path)) {

            //if create happend then unset tmp_path cause we dont want it any more
            unset($this->tmp_path);
            return true;
        } else {
            //if file not moving will not create and display this error message
            $this->custom_errors[] = "the file directory did not have premession";
            return false;
        }
    }

    public function ajax_save_user_image($user_image, $user_id)
    {
        global $database;
        $user_image = $database->escape_string($user_image);
        $user_id = $database->escape_string($user_id);

        $this->filename = $user_image;
        $this->id = $user_id;

        $sql = "UPDATE " . self::$db_table . " SET filename='{$this->filename}'";
        $sql .= " WHERE id={$this->id} ";

        $update_image = $database->query($sql);
        echo $this->image_path_and_placeholder();
    }

    public function delete_user_and_photo()
    {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;
            // unlike() predefined method to delete the file
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}
