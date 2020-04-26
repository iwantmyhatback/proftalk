<?php
/* if someone submits login information */
if(isset($_POST['login-submit']))
{

  require 'dbh.inc.php';
  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];

/* return 'empty fields header' if email/user or password are blank */
  if (empty($mailuid) || empty($password))
  {
        header("Location: ../index.php?error=emptyfields");
        exit();
  }

/* if not empty select all columns from student or professor where uName = input or email = input */
  else
  {
    $sql = "SELECT * FROM student WHERE uName=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);

/* create prepared statement */
      if (!mysqli_stmt_prepare($stmt, $sql))
        {
          header("Location: ../index.php?error=sqlerror");
          exit();
        }
      else
      {
/* bind variable to placeholders (?) in sql statement */
        mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
/* execute sql statement in database */
        mysqli_stmt_execute($stmt);
/* set $result as returned information */
        $result = mysqli_stmt_get_result($stmt);

          if ($row = mysqli_fetch_assoc($result))
          {
/* check for correct password input */
            $pwdCheck = password_verify($password, $row['password']);

              if($pwdCheck == false)
              {
                header("Location: ../index.php?error=wrongpwd");
                exit();
              }
              else if($pwdCheck == true)
              {
                session_start();
                $_SESSION['userUid'] = $row['uName'];
				$UniqueUserID = $row['uName'];

                header("Location: ../account.php?login=success");
                exit();
              }

              else
              {
                header("Location: ../index.php?error=wrongpwd");
                exit();
              }
          }
/* if the user is not found in student table move to professor table */
        else
        {
          $sql = "SELECT * FROM professor WHERE uName=? OR email=?;";
          $stmt = mysqli_stmt_init($conn);

        /* create prepared statement */
            if (!mysqli_stmt_prepare($stmt, $sql))
              {
                header("Location: ../index.php?error=sqlerror");
                exit();
              }
            else
            {
              /* bind variable to placeholders (?) in sql statement */
                      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
              /* execute sql statement in database */
                      mysqli_stmt_execute($stmt);
              /* set $result as returned information */
                      $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result))
                {
        /* check for correct password input */
                  $pwdCheck = password_verify($password, $row['password']);

                    if($pwdCheck == false)
                    {
                      header("Location: ../index.php?error=wrongpwd");
                      exit();
                    }
                    else if($pwdCheck == true)
                    {
                      session_start();
                      $_SESSION['userUid'] = $row['uName'];

                      header("Location: ../account.php?login=success");
                      exit();
                    }

                    else
                    {
                      header("Location: ../index.php?error=wrongpwd");
                      exit();
                    }
                }
                else
                {
                  header("Location: ../index.php?error=nouser");
                  exit();
                }
            }
        }
      }
  }
}
else
{
  header("Location: ../index.php");
  exit();
}
