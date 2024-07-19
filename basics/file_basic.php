<?php
//this file just to understand basic things about files 
echo __FILE__ . "<BR>"; //this show to you the full file directory with this file name
echo __DIR__ . "<br>"; //this show to ou the file directory without file name
echo __LINE__ . "<br>"; //this show to you the line number of this line -> 5

//"file_exists" predifined function to show you if the exist or not
if (file_exists(__DIR__)) {
    echo "yes" . "<BR>";
}

if (is_file(__DIR__)) {
    echo "yes" . "<br>";
} else {
    echo "no" . "<br>";
} //will echo no

if (is_file(__FILE__)) {
    echo "yes" . "<br>";
} else {
    echo "no" . "<br>";
} //will echo yes

if (is_dir(__DIR__)) {
    echo "yes" . "<br>";
} else {
    echo "no" . "<br>";
}//will echo yes
