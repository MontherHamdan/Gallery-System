<?php

class Db_object
{
    public $custom_errors = array();
    public $upload_errors_array = array(
        //key                          //value
        UPLOAD_ERR_OK =>          "There is no error",
        UPLOAD_ERR_INI_SIZE =>    "The uploaded file exceeds the UPLOAD_MAX_SIZE directive in php.ini",
        UPLOAD_ERR_FORM_SIZE =>   "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML file",
        UPLOAD_ERR_PARTIAL =>     "The uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE =>     "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR =>  "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE =>  "Failed to wrilte file to disk.",
        UPLOAD_ERR_EXTENSION =>   "A PHP extenstion stopped the file upload."
    );

    //method to get all user in database
    //  بدنا نخلي الميثود ستاتيك عشان نخلي استدعائه اسهل ونقلل الكود في عملية الاستدعاء
    public static function get_all()
    {
        return static::find_this_query("SELECT * FROM " . static::$db_table . " ");
    }

    //method to get name by id
    public static function get_by_id($id)
    {
        $sql = "select * from " . static::$db_table . " where id=$id limit 1";
        //use self when you want to use static method in same class
        $the_result_array = static::find_this_query($sql);
        //now we will use (array_shift) this predefined method will get for us the first item and we can have it as varible
        // if (!empty($the_result_array)) {
        //  $found_user=array_shift($the_result_array);
        //  return $found_user;
        // } else{
        //     return false;
        // }

        //instead of this long if clause we can use (ternary) 
        //no need to explain its like (if) condition but short way
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    //instead of calling query method from Database class in each method in User class we can make this method and call the method in other methods
    public static function find_this_query($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        //here we will do a loop to fetch array and use (instantiation) method to get the values and save it into empty array ($the_object_array)
        //instead of do a loop every time to return the data
        $the_object_array = array();
        while ($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }

    //method to instatiate the object for a properties and assigne the values to the array
    public static function instantiation($the_record)
    {
        //late static binding
        //instanstiate the called instead of use self when you want to make a parent
        $calling_class = get_called_class();
        // $the_object = new self;
        $the_object = new $calling_class;
        // $the_object->user_id = $found_user['id'];
        // $the_object->username = $found_user['username'];
        // $the_object->password = $found_user['password'];
        // $the_object->first_name = $found_user['name'];
        // $the_object->last_name = $found_user['lastname'];

        //instead of insatiate each property(atribute) like in above we will do loop to instiate it using (has_the_attribute) that we created down
        //we creat up object from User class call ($the_object)
        //تنساش عشان تزبط لازم يكون اسم المتغير نفس اسم الكولم بالداتا بيس 
        foreach ($the_record as $the_attribute => $value) {
            if ($the_object->has_the_attribute($the_attribute)) {
                //if true will give $the_attribute a $value
                $the_object->$the_attribute = $value;
            }
        }


        return $the_object;
    }

    //this method will check 
    private function has_the_attribute($the_attribute)
    {
        //predefined function(get_object_vars) returned all properties in the class
        //this functiion take the class name as a parameter
        $object_properties = get_object_vars($this);

        //and this predefined function check if the key exist or not and then we will make a return to check if it true or flase 
        //the key here is the class properties ($the_attribute)
        //function take two parameters 1-the_attribute, 2- $object_properties and will compare ($the_attribute) with all properties in the class if it exist or not
        return array_key_exists($the_attribute, $object_properties);
    }
    //this method when we call it will get to us the db_field properties in the class
    protected function properties()
    {
        $properties = array();

        foreach (static::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    //in this method we will take the pulling out the properties from properties() method
    //and escape the strings to clean the properties to use it with the abstracion process
    protected function clean_prperties()
    {
        global $database;
        $clean_prperties = array();

        foreach ($this->properties() as $key => $value) {
            $clean_prperties[$key] = $database->escape_string($value);
        }
        return $clean_prperties;
    }

    // for create method: everytime when we call create method it's creating the same information over and over
    //and it will not check if user is there or not and will have a lot of problems if we use the method like this 
    //so we will create a method to check if the user is there or not
    public function save()
    {
        //check if the id is there or not 
        //if yes save() method will call update() if not it will call create()
        return isset($this->id) ? $this->update() : $this->create();
    }


    // //1-Create first method of CRUD
    // public function create()
    // {
    //     global $database;
    //     //insert into users table
    //     // $sql = "INSERT INTO users (username,password,first_name,last_name)";
    //     //(abstracting tables)instead of that column above we will make the create method universal 
    //     //so we will define property have the database name and put it instead of put a databse name here
    //     $sql = "INSERT INTO " . self::$db_table . " (username,password,first_name,last_name)";
    //     $sql .= "VALUES('";
    //     $sql .= $database->escape_string($this->username) . "','";
    //     $sql .= $database->escape_string($this->password) . "','";
    //     $sql .= $database->escape_string($this->first_name) . "','";
    //     $sql .= $database->escape_string($this->last_name) . "')";

    //     //now we will execute the query usin(query) method from Database class
    //     //and put it in if statemnet to check if yes return true if not reuturn flase
    //     if ($database->query($sql)) {
    //         $this->id = $database->the_insert_id();
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    //here i will create another version of create() method after abstracting so you can see the diffrence
    //the thing that we are want to do is getting the keys (username,password,firstname,lastname...)
    //then put the values inside the keys
    public function create()
    {
        global $database;
        //(make it abstracting)1-get the all proerties in the class
        $properties = $this->clean_prperties();

        //2-we will use two predifined function 
        //first one to implode(its to get a string from array and seperate it) to seperate the keys like this (username,password,first_name,last_name)
        //seconed one is array_keys(it's to get keys from array) because i wanna pull out the arrays in that key
        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        //now we will do the abstraction for the values remeber we have a single coute(') around each string
        $sql .= "VALUES('" . implode("','", array_values($properties)) . "')";

        //now we will execute the query usin(query) method from Database class
        //and put it in if statemnet to check if yes return true if not reuturn flase
        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }

    // //2-Update seconed method of CRUD
    // public function update()
    // {
    //     global $database;

    //     $sql = "UPDATE " . self::$db_table . " SET ";
    //     $sql .= "username='" . $database->escape_string($this->username) . "', ";
    //     $sql .= "password='" . $database->escape_string($this->password) . "', ";
    //     $sql .= "first_name='" . $database->escape_string($this->first_name) . "', ";
    //     $sql .= "last_name='" . $database->escape_string($this->last_name) . "' ";
    //     $sql .= " WHERE id= " . $database->escape_string($this->id);

    //     //mysqli_affected_rows() predifined function to test if the rows updated or not
    //     $database->query($sql);
    //     return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    // }


    //another version of update method using abstrsction
    public function update()
    {
        global $database;

        $properties = $this->clean_prperties();
        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        //mysqli_affected_rows() predifined function to test if the rows updated or not
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


    //2-delete third method of CRUD
    public function delete()
    {
        global $database;
        $sql = "DELETE FROM " . static::$db_table . " ";
        $sql .= "WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    //this method passing $_FILES['uploaded_file'] as an argument
    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->custom_errors[] = "there was not file uploaded here";
            return false;
        } elseif ($file['error'] != 0) {
            $this->custom_errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            //basenmame() predefined function Return filename from the specified path
            //$file['name'] same like $_FILE['name']
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    //function to count rows in database to use it in chart and another thing
    public static function count_all()
    {
        global $database;
        //COUNT() is predefined function to count the column in database
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }
}
