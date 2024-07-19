<?php
//this autload function will auto declare the includes that we are forget to do 
//like when we forget to include file like this (include("user.php");)
//so when we forget to do include things this function will do it automatically for us 

//this functon will scanning all file that we put in
//for example we put this fil inside includes so this function will scan all files inside includes 
//so if it finds a file that is not include like user.php will going to catch it and pass it as a parameter 
//طبعا راح نضمن الفايل بملف الاينيت واذا بدك تختبر الفنكشن جرب شيل ملف تضمين ملف من الملفات
function my_autoloader($class)
{
    //هاض الفنكشن بضمن انو راح يكون الاحرف سمول عشان نضمن انو عنا الفايل الصح لانو اسم الكلاس بكون كابيتل بس اسم الفايل سمول
    $class = strtolower($class);
    //تعريف امتداد الملف
    $the_path = "includes/{$class}.php";

    if (file_exists($the_path)) {
        require_once($the_path);
    } else {
        echo "this file name {$class}.php was not found";
    }
}
// Register the autoload function
spl_autoload_register('my_autoloader');

//function to redirect user to another file based on the paramet
function redirect($location)
{
    header("Location: {$location}");
}
