<?php

$con = mysqli_connect('localhost', 'root', '', 'ajax3') or die("connection faild");


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $fetch_user = json_encode(mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM ajax WHERE `id`='$id'")));
    print_r($fetch_user);
}

?>