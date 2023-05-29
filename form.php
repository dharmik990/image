<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax3') or die("connection faild");
$select = "SELECT * FROM ajax";
$select = mysqli_query($con, $select);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajax form</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

    <style>

    </style>
</head>

<body>
    <h2>INSERT FORM</h2>
    <span id="success"></span>
    <span id="error"></span>

    <form id="form" method="post" enctype="multipart/form-data">
        <input type="text" name="id" id="id"><br>

        <label>name:</label><br>
        <input type="text" name="name"><br><br>
        <span id="name_err"></span><br>

        <label>email:</label><br>
        <input type="email" name="email"><br><br>
        <span id="email_err"></span><br>
        <div id="password">
            <label>password:</label><br>
            <input type="password" name="password"><br><br>
            <span id="password_err"></span><br>
        </div>
        <div id="cpassword">
            <label>conform password:</label><br>
            <input type="password" name="conform"><br><br>
            <span id="conform_err"></span><br>
        </div>

        <label>gender</label><br>
        <input type="radio" name="gender" value="male">:male<br>
        <input type="radio" name="gender" value="female">:female<br><br>
        <span id="gender_err"></span><br>

        <label>hobby<label><br>
                <input type="checkbox" name="hobby[]" value="criket">cricket<br>
                <input type="checkbox" name="hobby[]" value="football">football<br>
                <input type="checkbox" name="hobby[]" value="vollyball">vollyball<br><br>
                <span id="hobby_err"></span><br>

                <label>select your country:</label><br>
                <select name="select">
                    <option value="0" hidden selected>select your country:</option>
                    <option value="india">india</option>
                    <option value="australia">australia</option>
                    <option value="canada">canada</option>
                </select><br><br>
                <span id="select_err"></span><br>

                <label>profile</label><br>
                <input type="file" name="image"><br><br>
                <span id="file_err"></span><br>

                <label>multiple</label><br>
                <input type="file" name="multiple[]" multiple><br><br>
                <span id="multiple_err"></span><br>



                <input type="submit" name="submit" id="sbtn" onclick="submituser()" value="submit">


    </form>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        function submituser(){
        $('#form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'postins.php',
                type: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log(res)
                    $('#name_err').text('');
                    $('#email_err').text('');
                    $('#password_err').text('');
                    $('#conform_err').text('');
                    $('#gender_err').text('');
                    $('#hobby_err').text('');
                    $('#select_err').text('');
                    $('#file_err').text('');
                    $('#multiple_err').text('');

                    var x = JSON.parse(res);
                    if (x.status == 400) {
                        $('#name_err').text(x.name_err);
                        $('#email_err').text(x.email_err);
                        $('#password_err').text(x.password_err);
                        $('#conform_err').text(x.conform_err);
                        $('#gender_err').text(x.gender_err);
                        $('#hobby_err').text(x.hobby_err);
                        $('#select_err').text(x.select_err);
                        $('#file_err').text(x.file_err);
                        $('#multiple_err').text(x.multiple_err);
                        $('#match_err').text(x.multiple_err);


                    } else if (x.status == 200) {
                        $('#form')[0].reset();
                    }





                }




            })


        })
    }
        $(document).ready(function () {
            fetch_data();
        });
        function fetch_data() {
    
            $.ajax({
                url: 'table.php',
                type: 'get',

                success: function (res) {
                    $('#user_data').html(res);
                }
            });
        }

        function getdata(id) {
            
            alert("hello update");  
            $.ajax({
                url: 'getdata.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (res) {
                    let x = JSON.parse(res);
                    $('#id').val(x.id)
                    $('input[name="name"]').val(x.name)
                    // $('input[name="email"]').val(x.email)
                    // $('input[name="gender"][value=' + x.gender + ']').prop('checked', true)
                    // $('#password').hide();
                    // $('#cpassword').hide();
                    $('#sbtn').attr('onclick', 'updateUser()')
                    $('#sbtn').html('Update')
                    $('table').hide();
                }
            });
        }




    </script>


</body>

</html>