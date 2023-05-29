<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax3') or die("connection faild");
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$conform = $_POST['conform'];
$selected = $_POST['select'];
$res = [];


if (empty($name)) {
    $res['name_err'] = "name is required";
    $res['status'] = 400;
}
if (empty($email)) {
    $res['email_err'] = "email is required";
    $res['status'] = 400;
}
if (empty($password)) {
    $res['password_err'] = "password is required";
    $res['status'] = 400;
}
if (empty($conform)) {
    $res['conform_err'] = "conform password is required";
    $res['status'] = 400;
}
if ($password != $conform) {
    $res['match_err'] = "password does not match";
}
if (isset($_POST['gender'])) {
    $gender = $_POST['gender'];

} else {
    $res['status'] = 400;
}

if (isset($_POST['hobby'])) {
    $hobby = implode(',', $_POST['hobby']);
} else {
    $res['hobby_err'] = "hobby is required";
    $res['status'] = 400;
}
if (empty($selected)) {
    $res['select_err'] = "please select your country";
    $res['status'] = 400;
}
if (empty($_FILES['multiple']['name'][0])) {
    $res['multiple_err'] = "select more than 2 image";
    $res['status'] = 400;
}
if (empty($_FILES['image']['name'])) {
    $res['file_err'] = "image is required";
    $res['status'] = 400;
}

if (empty($res)) {
    $select = "SELECT * FROM ajax WHERE `email`='$email'";
    $select_exe = mysqli_query($con, $select);
    $count = mysqli_num_rows($select_exe);
    if ($count > 0) {
        $res['count_err'] = "user exist";
        $res['status'] = 400;
    } else {

        $explode = explode('.', $_FILES['image']['name']);
        $ext = end($explode);
        $image = time() . '.' . $ext;
        $tmp_name = $_FILES['image']['tmp_name'];
        $folder = "img/" . $image;
        $upload = move_uploaded_file($tmp_name, $folder);
        if ($upload) {
            $multiple = $_FILES['multiple'];
            if (count($_FILES['multiple']['name']) >= 2) {
                $multiple_image = array();
                for ($i = 0; $i < count($multiple['name']); $i++) {
                    $rand = rand(100000, 999999);
                    $explode = explode(".", $multiple['name'][$i]);
                    $extension = end($explode);
                    $multiple_image[] = $rand . "." . $extension;
                    move_uploaded_file($multiple['tmp_name'][$i], "img/" . $multiple_image[$i]);
                }
                $images = implode(',', $multiple_image);
                if (isset($images)) {
                    $insert = "INSERT INTO ajax(`name`,`email`,`password`,`gender`,`hobby`,`country`,`profile`,`multiple`)VALUES('$name','$email','$password','$gender','$hobby','$selected','$image','$images')";
                    $insert_exe = mysqli_query($con, $insert);

                    $res['success'] = "Data insert successfully";
                    $res['status'] = 200;

                }

            }


        }

    }

}




echo json_encode($res);



?>