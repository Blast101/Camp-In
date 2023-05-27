<?php
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
    {
        header("location:login.php");
        exit; //exits php scripts
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="partials/_nav.css">
    <style>

        /* #tabs_link {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        } */
    </style>
</head>

<body>
    <?php
            require 'partials/_nav.php';
            require 'partials/_dbconnect.php';	
    ?>
    <div class="container">
        <div class="pages">
            <div class="btns">
                <div id="tabs_link">

                    <div class="btn1">											
                        <a href="javascript:void(0)" id='test1' class="tab">upload</a>
                    </div>

                    <div class="btn2">
                        <a href="javascript:void(0)" id='test2' class="tab not_active">create</a>
                    </div>

                    <div class="btn3">
                        <a href="javascript:void(0)" id='test3' class="tab not_active">display</a>
                    </div>

                    <div class="btn4">
                        <a href="javascript:void(0)" id='test4' class="tab not_active">Personal</a>
                    </div>
                </div>
                <!-- tabs_link  -->
            </div> 
            <!-- btn  -->

            <div id='box_test1' class="tab_box">
                <!-- <h1>hello</h1> -->
                <!-- <div class="sb">
                    <div class="sb1">search bar</div>
                    <div class="btn">button</div>
                </div> -->

            <center>
            <form action="#" method="post" enctype="multipart/form-data"> 
                <!-- enctype is importent while uploading files  -->
                
                <div>
                    Upload Pictures : <input type="file" name ='uploadfile'>
                </div>

                <br>
                <div>
                    Enter description : <input type="text" name ="desc">
                </div>
                <br>
                <div>
                    Enter Camp Name : <input type = "text" name = "Cname">
                </div>

                 <input type="submit" value="POST" name ='upload'>
            </form>
           </center>
    
    <?php
    session_start();
        if($_POST['upload'])
        {
            $uname = $_SESSION['username'];

            $file_name = $_FILES["uploadfile"]["name"];
            $temp_name = $_FILES["uploadfile"]["tmp_name"];
            $folder = "images/".$file_name;
            move_uploaded_file($temp_name,$folder);

            $description = $_POST['desc'];

            $cname = $_POST['Cname'];

            $sql = "INSERT INTO `$cname` (`cname`,`uname`,`files`,`desc`) VALUES ('$cname','$uname','$folder','$description')";

            
            $q1 = mysqli_query($conn,$sql);

            if($q1)
            {
                    echo "Suxx1";
            }
            else
            {
                echo "Failed1";
            }

            $sql6 = " INSERT INTO `Global` (`cname`,`uname`,`file`,`description`) VALUES ('$cname','$uname','$folder','$description')";
            $q6 = mysqli_query($conn,$sql6);

            if($q6)
            {
                    echo "Suxx2";
            }
            else
            {
                echo "Failed2";
            }
           
        }
    ?>

            </div>
            <!-- tab1 ///////////////////////////////////////////////////////////////////////////////////////////////////// -->

  <div id='box_test2' class="tab_box hide">
       
            <div>


            <center>
            <form action="#" method="post" enctype="multipart/form-data"> 
                <!-- enctype is importent while uploading files  -->
                
                
                    Enter Camp Name : <input type="text" name ='cname'>
            
                 <input type="submit" value="Create" name ='Create'>
            </form>
            </center>

    
    <?php
         require 'partials/_dbconnect.php'; 
        if($_POST['Create'])
        {
            $cname = $_POST['cname'];
            $admin = $_SESSION['username'];
            
            $sql2 = "CREATE TABLE `$cname` 
            (
                  `id` INT(10) AUTO_INCREMENT PRIMARY KEY,
                  `cname` VARCHAR(20) ,
                  `uname` VARCHAR(30) ,
                  `files` VARCHAR(400) ,
                  `desc` VARCHAR(100) 
            )";               
                
                $q2 = mysqli_query($conn,$sql2);

                if($q2)
                {
                    echo "executed";
                }
                else
                {
                    echo "Failed";
                }


                $sql5 = " INSERT INTO Clists (`admin`,`cname`) VALUES ('$admin','$cname')";
                $q5 = mysqli_query($conn,$sql5);

                

                if($q5)
                {
                    echo "inserted";
                }
                else
                {
                    echo "Failed";
                }
        }
    ?>
            </div>
            
 </div>
             <!-- tab2 //////////////////////////////////////////////////////////////////////////////////////////////////// -->


<div id='box_test3' class="tab_box hide">
            <?php
                require 'partials/_dbconnect.php'; 
                $sql6 = "SELECT * FROM Global ";

                $q6 = mysqli_query($conn,$sql6);

                $total = mysqli_num_rows($q6);

            if($total!=0)
            {

            ?>
                <table border=1 cellspacing=7 width=100%>
                <tr>
                    <th width=10%>ID</th>
                    <th width=10%>Cname</th>
                    <th width=15%>Uname</th>
                    <th width=15%>Image</th>
                    <th width=10%>description</th>
                </tr>
     
            <?php
                while($result =  mysqli_fetch_assoc($q6))
                {
                  echo " 
                  <tr>
                  <td style='text-align:center'>".$result['id']."</td>
                  <td style='text-align:center'>".$result['cname']." </td>
                  <td style='text-align:center'>".$result['uname']."</td>
                  <td><img src = '".$result['file']."' heigt='100px' width='100px'</td>
                  <td style='text-align:center'>".$result['description']."</td>
                  </tr>";                
                }
              }
              else
              {
                  echo "No record found ";
              }
            ?>
            </table>
</div>
             <!-- tab3 ///////////////////////////////////////////////////////////////////////////////////////////////////// -->


            <div id='box_test4' class="tab_box hide">
                <h1>personal</h1>
            </div>

             <!-- tab4 ///////////////////////////////////////////////////////////////////////////////////////////////////// -->

            <script>
                let tab = document.querySelector('#tabs_link');

                tab.addEventListener('click', function (e) {
                    let id = e.target.id;

                    let ele = document.querySelectorAll('.tab_box');

                    let len = ele.length;

                    for (let x = 0; x < len; x++) {
                        ele[x].classList.add('hide')
                    }
                    // document.querySelector('.tab_box').classList.add('hide');
                    document.querySelector('#box_' + id).classList.remove('hide');


                    let ele1 = document.querySelectorAll('.tab');

                    let len1 = ele1.length;

                    for (let x = 0; x < len1; x++) {
                        ele1[x].classList.add('not_active')
                    }
                    // document.querySelector('.tab_box').classList.add('hide');
                    document.querySelector('#' + id).classList.remove('not_active');

                });
            </script>

            <div class=" sp">
                <div class="sb2">
                    <div class="sbar">searchbar</div>
                </div>

                <div class="stabs">Camp1</div>
                <div class="stabs">Camp2</div>
                <div class="stabs">Camp3</div>
                <div class="stabs">Camp4</div>

            </div>
        </div>
        <!-- pages  -->
    </div>
   <!-- container  -->

</body>
</html>