<?php
include('templates/header.php');

if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
{
    if(isset($_SESSION['loggedIn']))
    {
        if(isset($_SESSION['is_admin']))
        {
            if($_SESSION['is_admin'] === 1)
            {
                $username_query = "SELECT * FROM users ORDER by username";
                $result = mysqli_query($dbc, $username_query);
                
                print '<h3>Administrator Functions</h3>';
                
                $username_selected = '';
                $username;
                $status;
                $admin;
                
                print "<form method='post'>"
                            . "Username : <select name='user_selected' style='width:25%'>";

                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                {
                    //printf ("%s (%s)\n", $row["username"], $row["status"]) . '<br>';
                    $username[] = $row['username']; 
                    $status[] = $row['status'];
                    $admin[] = $row['admin'];
                    $user_field = $row['username']; 
                    print '<option value=' . $user_field . '>' . $user_field . '</option>';
                }

                print "</select>
                            <input type='submit' value='Select User' name='submit'>
                            </form>";

                if($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    if(isset($_POST['user_selected']))
                    {
                        $username_selected = $_POST['user_selected'];
                        $_SESSION['username_to_use'] = $username_selected;
                        //print "The username &nbsp&nbsp <span style='font-weight:bold; font-size:120%'>" . $username_selected . "&nbsp&nbsp </span> is currently selected.";
                    }
                    $admin_query = "SELECT status, admin FROM users WHERE username = '$username_selected'";
                    $result = mysqli_query($dbc, $admin_query);
                    $row = mysqli_fetch_array($result);

                    if($row['admin'] === "Y")
                    {
                        $admin_action = "Revoke";
                    }
                    else
                    {
                        $admin_action = "Grant";
                    }
                    print  "<br>
                            <br>
                            <form method='post'>
                                <h4>Account Options</h4>";
                    if($row['status'] === "OPEN")
                    {
                        print  "<input type='radio' name='account_options' value='open' checked> Set <span style='font-weight:bold'>" . $_SESSION['username_to_use'] . "</span> to Open<br>
                        <input type='radio' name='account_options' value='locked'> Set <span style='font-weight:bold'>" . $_SESSION['username_to_use'] . "</span> to Lock<br>";
                    }
                    else
                    {
                        print  "<input type='radio' name='account_options' value='open'> Set <span style='font-weight:bold'>" . $_SESSION['username_to_use'] . "</span> to Open<br>
                        <input type='radio' name='account_options' value='locked' checked> Set <span style='font-weight:bold'>" . $_SESSION['username_to_use'] . "</span> to Lock<br>";
                    }
                               
                    print "     <input type='radio' name='account_options' value='grant_admin'> " . $admin_action . " <span style='font-weight:bold'>" . $_SESSION['username_to_use'] . "</span> Admin Status<br>
                                <input type='radio' name='account_options' value='delete_account'> Delete This Account (<span style='font-weight:bold'>" . $_SESSION['username_to_use'] . "</span>)<br>
                                <input type='submit' name='submit_admin_changes' value='Submit Changes'>
                            </form>
                    ";
                   
                    if($_SERVER['REQUEST_METHOD'] === 'POST')
                    {
                        if(isset($_POST['account_options']))
                        {   
                            $current_option = $_POST['account_options'];
                            $username_to_check = $_SESSION['username_to_use'];
                            
                            if($current_option === 'open')
                            {
                                $query = "UPDATE users SET status = 'OPEN' WHERE username = '$username_to_check'";
                                if($dbc->query($query) === TRUE)
                                {
                                    print "<span style='font-weight:bold'>" . $username_to_check . "'s</span> account status has been set to OPEN. <br>";
                                }
                                else
                                {
                                    print "Error occurred: " . $dbc->error;
                                }
                            }
                            if($current_option === 'locked')
                            {
                                $query = "UPDATE users SET status = 'LOCKED' WHERE username = '$username_to_check'";
                                if($dbc->query($query) === TRUE)
                                {
                                    print "<span style='font-weight:bold'>" . $username_to_check . "'s</span> account status has been set to LOCKED. <br>";
                                }
                                else
                                {
                                    print "Error occurred: " . $dbc->error;
                                }
                            }
                            if($current_option === 'grant_admin') // If admin radio selected..
                            {
                                // Get selected user properties
                                $admin_query = "SELECT admin FROM users WHERE username = '$username_to_check'";
                                $result = mysqli_query($dbc, $admin_query);
                                $row = mysqli_fetch_array($result);
                                
                                if($row['admin'] === 'Y') // If selected user is admin, change to 'N'
                                {
                                    $query = "UPDATE users SET admin = 'N' WHERE username = '$username_to_check'";
                                    if($dbc->query($query) === TRUE)
                                    {
                                        print "<span style='font-weight:bold'>" . $username_to_check . "</span> has had its admin status revoked. <br>";
                                    }
                                    else
                                    {
                                        print "Error occurred: " . $dbc->error;
                                    }
                                }
                                else // If selected user is not admin, change to 'Y', and set status to "OPEN"
                                {
                                    $query = "UPDATE users SET admin = 'Y', status = 'OPEN'WHERE username = '$username_to_check'";
                                    if($dbc->query($query) === TRUE)
                                    {
                                        print "<span style='font-weight:bold'>" . $username_to_check . "</span> has been granted admin status. <br>";
                                    }
                                    else
                                    {
                                        print "Error occurred: " . $dbc->error;
                                    }
                                }
                            }
                            if($current_option === 'delete_account') // If delete radio selected..
                            {
                                // Delete user from table
                                $query = "DELETE FROM users WHERE username = '$username_to_check'";
                                if($dbc->query($query) === TRUE)
                                {
                                    // Delete files then folder of user.
                                    $dir_to_delete = "uploads/" . $username_to_check . "/";
                                    if(delete_directory($dir_to_delete))
                                    {
                                        print "The account <span style='font-weight:bold'>" . $username_to_check . "</span> has been deleted. <br>";
                                    }
                                    else
                                    {
                                        print "Deleting the user's directory and files was unsuccessful.";
                                    }
                                }
                                else
                                {
                                    print "Error deleting account: " . $dbc->error;
                                }
                                
                            }
                        }
                    }
                }
            }
            else
            {
                print 'You must be an admin to use this page.';
            }
        }
        else
        {
            print 'You must be an admin to use this page.';
        }
    }
}

function delete_directory($dirname) 
{
    if (is_dir($dirname))
    {
        $dir_handle = opendir($dirname);
	if (!$dir_handle)
	{
            return false;
        }
        else
        {
            while($file = readdir($dir_handle))
	    {   
                if ($file != "." && $file != "..")
	        {
                    if (!is_dir($dirname."/".$file))
	            {
                        unlink($dirname."/".$file);
                    }
	            else
                    {
                        delete_directory($dirname.'/'.$file);
                    }
	        }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
	}

    }
}

include('templates/footer.php');
?>