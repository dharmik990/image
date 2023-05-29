<?php

$con = mysqli_connect('localhost', 'root', '', 'ajax3') or die("connection faild");



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tables</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">



    <style>
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1>UPDATE FORM</h1>
    <form id="data" method="post" enctype="multipart/form-data" style="display:none;">
        <label>id:</label><br>
        <input type="text" name="id"><br><br>

        <label>name:</label><br>
        <input type="text" name="name"><br><br>

        <label>email:</label><br>
        <input type="email" name="email"><br><br>

        <div id="password">
            <label>password:</label><br>
            <input type="password" name="password"><br><br>
        </div>
        <div id="cpassword">
            <label>conform password:</label><br>
            <input type="password" name="conform"><br><br>
        </div>

        <label>gender</label><br>
        <input type="radio" name="gender" value="male">:male<br>
        <input type="radio" name="gender" value="female">:female<br><br>

        <label>hobby</label><br>
        <input type="checkbox" name="hobby[]" value="criket">cricket<br>
        <input type="checkbox" name="hobby[]" value="football">football<br>
        <input type="checkbox" name="hobby[]" value="vollyball">vollyball<br><br>

        <select name="country" id="select">
            <option value="0" hidden selected>select your country:</option>
            <option value="india">india</option>
            <option value="australia">australia</option>
            <option value="canada">canada</option>
        </select><br><br>

        <label>profile</label><br>
        <input type="file" name="image"><br><br>

        <label>multiple</label><br>
        <input type="file" name="multiple[]" multiple><br><br>

        <button type="button" name="submit" id="sbtn" onclick="updateUser()">submit</button>



    </form>

    <h1>view</h1>
    <table>
        <thead>
            <th>ID</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>PASSWORD</th>
            <th>GENDER</th>
            <th>HOBBY</th>
            <th>COUNTRY</th>
            <th>IMAGE</th>
            <th>IMAGES</th>
            <th>CREATE</th>
            <th>UPDATE</th>
            <th colspan="2">ACTION</th>
        </thead>

        <tbody id="user_data">


        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>


    <script>
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
           
            $.ajax({
                url: 'getdata.php',
                type: 'post',
                data: {
                    id: id
                },
                success: function (res) {
                    let x = JSON.parse(res);
                    $('input[name="id"]').val(x.id)
                    $('input[name="name"]').val(x.name)
                    $('input[name="email"]').val(x.email)
                    $('input[name="gender"][value=' + x.gender + ']').prop('checked', true)
                    let h = (x.hobby).split(',');
                    for (let index = 0; index < h.length; index++) {
                        $('input[name="hobby[]"][value=' + h[index] + ']').prop('checked', true)
                    }
                    $('select[name="country"]').val(x.country)
                    $('#password').hide();
                    $('#cpassword').hide();
                    $('#sbtn').attr('onclick', 'updateUser()')
                    $('#sbtn').html('Update')
                    $('table').hide();
                    $('#data').show();
                }
            });
        }
        function delete_user(id) {

            $.ajax({
                url: 'table.php?delete_user=' + btoa(id),
                type: 'get',
                success: function (res) {
                    fetch_data();
                    var x = JSON.parse(res);

                }
            })
        }
        function updateUser(id) {
       
          
            $.ajax({

                url: 'update.php?getdata=' + id,

                type: 'post',
                data: new FormData(document.getElementById('data')),
                processData: false,
                 contentType: false,
                success: function (res) {
                    // $('#data')[0].reset();
                    let a = JSON.parse(res);
                    
                    $('#password_input').show();
                    
                    $('#sbtn').attr('onclick', 'submituser()')
                    $('#sbtn').html('submit')
                    fetch_data();
                    $('#data').hide();
                    $('table').show();
                }
            })
        }

    </script>
</body>

</html>