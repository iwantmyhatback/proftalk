<?php

if (isset($_POST['signup-submit']))
{
  require 'dbh.inc.php';
  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $firstname = $_POST['fname'];
  $lastname = $_POST['lname'];
  $emplid = $_POST['empl'];
  $phone = $_POST['phone'];
  $password = $_POST['pwd'];
  $passwordrepeat = $_POST['pwd-repeat'];



  /* stop empty fields from passing*/
  if(empty($username) || empty($email) || empty($firstname) || empty($lastname) || empty($emplid) || empty($phone) ||empty($password) || empty($passwordrepeat))
  {
    header("Location: ../studentsignup.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  /* check for valid email AND username */
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
      header("Location: ../studentsignup.php?error=invalidmailuid");
      exit();
    }
    /* check for valid email */
      else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        header("Location: ../studentsignup.php?error=invalidmail&uid=".$username);
        exit();
      }
      /* check user characters are valid */
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
            header("Location: ../studentsignup.php?error=invaliduid&mail=".$email);
            exit();
        }
        /*check password inputs match */
          else if ($password !== $passwordrepeat)
          {
            header("Location: ../studentsignup.php?error=passwordcheck&uid=".$username."&mail=".$email);
            exit();
          }
else
{
  $sql = "SELECT uName FROM student WHERE uName=?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
      header("Location: ../studentsignup.php?error=sqlerror");
      exit();
    }
      else
      {
        /* check username availability */
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
          if ($resultCheck>0)
          {
            header("Location: ../studentsignup.php?error=usertaken&mail=".$email);
            exit();
          }
            else
            {
              /* send all info to database */
              $sql = "INSERT INTO student (uName, email, fName, lName, empl, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
              $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql))
                {
                  /* check database connection */
                  header("Location: ../studentsignup.php?error=sqlerror");
                  exit();
                }
                  else
                  {
                    /* hash password for database entry */
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $firstname, $lastname, $emplid, $phone, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../studentsignup.php?signup=success");
                  }
            }
      }
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
}
else
{
  header("Location: ../studentsignup.php");
  exit();
}
