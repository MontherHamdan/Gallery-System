<?php


//will make the user class extend from db_object(will put in this class the method 
//that we will use it univesality(for multiple tables like get_all() method)) to inherent the method and property from it
//so previously we was have these methods in the user class but we want to make this methods universal 
//so we make another class to handle these methods
//بالمختصر الميثود اللي بنستخدمها بشكل شائع بغض النظر عن الكلاس اللي هية فيه بدنا ننقلهم على الكلاس الجديد
// ونعمل اكستند من هضاك الكلاس وهاض الاشي يسمى انهيرتنس وهاض الاشي بسهل علينا بدل ما نضل نعمل نسخ ولصق
// inheritence
class Comment extends Db_object
{
    // (abstracting tables) this abstraction property
    protected static $db_table = "comment";
    //array to save db_table keys to use it with abstraction methods
    protected static $db_table_fields = array('id', 'photo_id', 'author', 'body');

    //properties to easily get the user information from database (must be based on your coulmns in database table)
    public $id;
    public $photo_id;
    public $author;
    public $body;

    public static function create_comment($photo_id, $author = "john", $body = "")
    {
        if (!empty($photo_id) && !empty($author) && !empty($body)) {
            //self instantiation
            $comment = new Comment;

            $comment->photo_id = (int)$photo_id;
            $comment->author = $author;
            $comment->body = $body;
            return $comment;
        } else {
            return false;
        }
    }

    public static function find_comments($photo_id = 0)
    {
        global $database;
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE photo_id=" . $database->escape_string($photo_id);
        $sql .= " ORDER BY id ASC";

        return self::find_this_query($sql);
    }
}
