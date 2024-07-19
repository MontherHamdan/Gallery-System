<?php

if (isset($_POST['submit'])) {
    //<pre> make space for array in nice way 
    echo "<pre>";
    print_r($_FILES['file_upload']);
    echo "<pre>";

    //this array to handle error on file upload you can see the error types on lecture(76)
    //the keys is error for upload file if on of them happend the will store the value in the array
    $upload_errors = array(
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

    //القيم اللي جوا بكونو على شكل ارراي بتقدر تشوفهم لما طبعنا     print_r($_FILES['file_upload']);
    $temp_name = $_FILES['file_upload']['tmp_name'];
    $the_file = $_FILES['file_upload']['name'];
    $directory = "uploads/";

    //move_uploaded_file() predefined function to move uploaded file 
    //takes two parameter temp file name and distination for the new file location(directory)
    if (move_uploaded_file($temp_name, $directory . "_" . $the_file)) {
        $the_message = "the file moved successfully";
    } else {
        $the_error = $_FILES['file_upload']['error'];

        $the_message = $upload_errors[$the_error];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- (enctype) to inform program that we will use another type of data like images or files  -->
    <form action="upload_files.php" enctype="multipart/form-data" method="post">
        <h2>
            <?php
            if (!empty($upload_errors)) {
                echo $the_message;
            }
            ?>
        </h2>

        <input type="file" name="file_upload">
        <br>
        <br>
        <input type="submit" name="submit">
    </form>
</body>

</html>