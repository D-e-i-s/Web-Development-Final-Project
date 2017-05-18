<?php
    include('templates\header.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {    
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
        {
            $qryPassword = "SELECT username, password, status, admin FROM users WHERE username = '$username'";
            $queryPassword = mysqli_query($dbc, $qryPassword);
            $row = mysqli_fetch_array($queryPassword);
            if($row['status'] === "OPEN")
            {
                if(password_verify($password, $row['password']) )
                {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['loggedIn'] = true;
                    
                    // Checks if a directory exists for the user, if not, creates it
                    if(!file_exists("uploads/" . $_SESSION['username'] . "/"))
                    {
                        mkdir("uploads/" . $_SESSION['username'] . "/");
                    }
                    
                    // Checks if user is admin, if is, sets flag
                    if($row['admin'] === "Y")
                    {
                        $_SESSION['is_admin'] = 1;
                    }
                    else
                    {
                        $_SESSION['is_admin'] = 0;
                    }
                    print 'You have successfully logged in.<br><br>';
                    print '<br><br>';
                    print '<a href="index.php">Return to Techify homepage</a>';
                }
                else
                {
                    print 'You have failed to log in.  Your username or password are incorrect. <br><br>';
                    print '<a href="login.php">Return to Login</a>';
                }
            }
            else
            {
                print 'Your account is currently locked.';
            }
        }
    }
    else
    {
        print '<h2>Login</h2>
            <br>
        <form method="post">
            Username: <input type="text" style="width:25%" name="username" required>
            <br><br>
            Password: <input type="password"  style="width:25%" name="password" required>
            <br><br>
            <input type="submit" value="Login" name="submit">
        </form>';
    }

    include('templates\footer.php');
?>