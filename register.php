<?php
include('templates/header.php');


if(!isset($_SESSION['loggedIn']))
{
    
    print 'Please register to create your own account.<br><br>';
    
    print   '<form method="post">
                Username: <input type="text" name="username" style="width:25%"><br><br>
                Password: <input type="password" name="password" style="width:25%"><br><br>
                Confirm Password: <input type="password" name="passwordconfirm" style="width:25%"><br><br>
                <input type="submit" value="Register" name="submit">
            </form>';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordconfirm = $_POST['passwordconfirm'];
        $userpath = "uploads/" . $username . "/";
        
        if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
        {
            if($username != '')
            {

                    if($password != $passwordconfirm)
                    {
                        print '<p style="color:red">Your passwords do not match.</p>';
                    }
                    else if($password === '' || $passwordconfirm === '')
                    {
                        print '<p style="color:red">You must enter a password and confirm the password.</p>';
                    }
                    else if($password === $passwordconfirm)
                    {                        
                        // Check if username exists 
                        $qry = "SELECT * FROM users WHERE username='".$username."'"; 
                        $query = mysqli_query($dbc, $qry);
                        
                        if(mysqli_num_rows($query) > 0)
                        {
                            echo "That username already exists.";
                        }
                        else
                        {   
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            
                            // register user
                            $query = "INSERT INTO users (username, password, user_dir, status, admin) VALUES ('$username', '$hashedPassword', '$userpath', 'OPEN', 'N')";
                            ($dbc->query($query));
                            print '<p style="color:green">You have successfully created an account.</p> <br>';
                            print '<a href="login.php">Login</a>';
                        }
                    }
            }
            else
            {
                print 'You cannot leave the username field blank.';
            }
        }

    }
}
else
{
    print 'You are already logged in.';
}







include('templates/footer.php');
?>