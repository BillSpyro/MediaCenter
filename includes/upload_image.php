<?php
$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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

if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
  echo "File is valid and was successfully uploaded.";
}
?>
