<?php
include('templates\header.php');


if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
{
    if(isset($_SESSION['loggedIn']))
    {
        $id_num = $_GET['id'];

        $update_query = "SELECT text, author, favorite FROM quotes WHERE id = '$id_num'";
        $result = mysqli_query($dbc, $update_query);
        $row = mysqli_fetch_array($result);
        
        $fav_value = "{$row["favorite"]}";

        if($fav_value === "Y")
        {
            $fav_value = "checked";
        }
        else
        {
            $fav_value = "";
        }        
                
        print " <form method='post'>
                Author: <input type='text' name='quote_author' style='width: 25%' value =\"" . $row["author"] . "\" required><br><br>
                Quote Text: <br><textarea name='quote_text' rows='6' style='width: 30%' required>" . $row["text"] . "</textarea><br><br>
                <input type='checkbox' name='quote_is_favorite' $fav_value>  Add quote as favorite <br><br>
                <input type='submit' value='Update Quote' name='submit'>
            </form>
        ";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $quote_text = $_POST['quote_text'];
            $quote_author = $_POST['quote_author'];
            
            // Make sure that checkbox value is not unset/undefined
            if(!isset($_POST['quote_is_favorite']))
            {
                $fav_value = 'N';
            }
            else 
            {
                $fav_value = 'Y';
            }               

            $query = "UPDATE quotes SET text = '$quote_text', author = '$quote_author', favorite = '$fav_value' WHERE id = '$id_num'";

            if (mysqli_query($dbc, $query)) 
            {
                echo "Quote updated successfully<br><br>";
            } 
            else 
            {
                echo "Error updating record: " . mysqli_error($dbc);
            }
            print '<a href="quotes.php">Return to quotes</a>';
        }
        
    }
    else
    {
        print 'You must be logged in to edit quotes.';
    }
}


include('templates\footer.php');
?>
