<?php
#if(isset($_POST['name'] || $_POST['roll'] || $_POST['contact'] || $_POST['ev1'] || $_POST['ev2'] || $_POST['ev3'])){
$name = $_POST['name'];
$roll = $_POST['roll'];
$contact = $_POST['contact'];
$ev1 = $_POST['ev1'];
$ev2 = $_POST['ev2'];
$ev3 = $_POST['ev3'];
#}


if (!empty($name) || !empty($roll) || !empty($contact) || !empty($ev1) || !empty($ev2) || !empty($ev3)) {

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "demo";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connection failed (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT roll From anarghya Where roll = ? Limit 1";
        $INSERT = "INSERT Into anarghya (name,roll,contact,ev1,ev2,ev3) values(?,?,?,?,?,?)";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $roll);
        $stmt->execute();
        $stmt->bind_result($roll);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if ($rnum == 0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssisss", $name, $roll, $contact, $ev1, $ev2, $ev3);
            $stmt->execute();
            $message = "successfull register";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header('Location:index.html', 2);
        } else {
            $message = "SomeOne is Already is registered with this roll no.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    $message = "All field are required to fill";
    echo "<script type='text/javascript'>alert('$message');</script>";
    die();
}
