<?php
$not_empty = !empty($_FILES['picture']['tmp_name']);
$target_dir = $_SERVER['DOCUMENT_ROOT'].'/CodingLab/web/menu/';
$target_file = $target_dir . basename($_FILES["picture"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"]) && $not_empty) {
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $messageAboutFile =  "File is not an image.";
        $uploadOk = 0;
    }
} else {
    $uploadOk = 0;
    $messageAboutFile =  'Picture is not saved.<br/>';
}

// Check if file already exists
if (file_exists($target_file) && $not_empty) {
    $messageAboutFile =  "File already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["picture"]["size"] > 5000000 && $not_empty) {
    $messageAboutFile =  "Your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $messageAboutFile =  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
        $messageAboutFile =  "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
    } else {
        $messageAboutFile =  "Sorry, there was an error uploading your file.";
    }
}