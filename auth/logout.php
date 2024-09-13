<?php require "../includes/student_session.php" ?>
<?php 

    if(!isset($_SESSION['stu_ine'])){
        header("location: ../auth/login.php");
        exit();
    } else {
        session_start();
        session_unset();
        session_destroy();

        header("location: ../");
        exit();
    }

?>