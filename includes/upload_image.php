<?php
// target dir is the target directory
$target_dir = "../images/";
// the target file is what we upload
$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
// uploadOk is a variable to check and make sure things are correct
$uploadOk = 1;
// what type of image it is
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// use check to make sure its not too big
$check = getimagesize($_FILES['fileToUpload']['tmp_name']);
if ($check !== false) {
  $uploadOk = 1;
} else {
  $uploadOk = 0;
}

// file already exists
if (file_exists($target_file)) {
  $uploadOk = 0;
}
// file bigger than 5mb
if ($_FILES['fileToUpload']['size'] > 5242880) {
  $uploadOk = 0;
}
// not a JPG, PNG or JPEG
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  $uploadOk = 0;
}

//$uploadOk == 1 && 
// if it all worked out, echo that it was successful
if ($uploadOk == 1 && move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
  echo "File is valid and was successfully uploaded.";
}
?>
