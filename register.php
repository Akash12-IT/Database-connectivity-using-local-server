<?php
$uname  = $_POST['uname'];
$uemail  = $_POST['uemail'];
$upass1 = $_POST['upass1'];
$upass2 = $_POST['upass2'];


if (!empty($uname) || !empty($uemail) || !empty($upass1) || !empty($upass2)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "registration";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname,);

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
    } else {
        $SELECT = "SELECT uemail FROM register Where uemail=? Limit 1";
        $INSERT = "INSERT Into register(uname,uemail,upass1,upass2)values(?,?,?,?)";

        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $uemail);
        $stmt->execute();
        $stmt->bind_result($uemail);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        //checking username
        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $uname, $uemail, $upass1, $upass2);
            $stmt->execute();
            echo "New record inserted sucessfully";
        } else {
            echo "Someone already register using this email";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All field are required";
    die();
}
