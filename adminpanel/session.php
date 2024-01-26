<?php 
 ob_start();
 session_start();
 if ($_SESSION['login'] == false) {
  header("location:login.php");
}