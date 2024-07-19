<?php
class Photo extends Db_object
{
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id', 'title', 'caption', 'description', 'filename', 'alternate_text', 'type', 'size');
    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;
    public $tmp_path;
    public $upload_directory = "images";




    //method to make the picture path dynamic
    //everytime when we call this method from anywhere, we will getting our upload directory
    public function picture_path()
    {
        return $this->upload_directory . DS . $this->filename;
    }

    public function save_file()
    {
        if ($this->id) {
            $this->update();
        } else {
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
                if ($this->create()) {
                    //if create happend then unset tmp_path cause we dont want it any more
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                //if file not moving will not create and display this error message
                $this->custom_errors[] = "the file directory did not have premession";
                return false;
            }
        }
    }

    public function delete_photo()
    {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;
            // unlike() predefined method to delete the file
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }

    public static function display_sidebar_data($photo_id)
    {
        $photo = self::get_by_id($photo_id);

        $output = "<a class='thumnail' href='#'><img width='100' src='{$photo->picture_path()}'></a>'";
        $output .= "<p>{$photo->filename}</p>";
        $output .= "<p>{$photo->type}</p>";
        $output .= "<p>{$photo->size}</p>";

        return $output;
    }
}
