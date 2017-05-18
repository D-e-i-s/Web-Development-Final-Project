<?php
include('templates/header.php');

if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
{
    if(isset($_SESSION['loggedIn']))
    {
        print ' <form method="post">
                    Author: <input type="text" name="author" style="width: 25%" required><br><br>
                    Quote Text: <br><textarea name="quote_text" rows="6" style="width: 30%" required></textarea><br><br>
                    <input type="checkbox" name="is_favorite" value="Y">  Add quote as favorite <br><br>
                    <input type="submit" value="Submit Quote" name"submit">
                </form>
        ';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $author = $_POST['author'];
            date_default_timezone_set('America/Chicago');
            $date_entered = date("Y-m-d h:i:s a");
            $quote_text = $_POST['quote_text'];
            
            //checks and sets favorite value for db
            if(isset($_POST['is_favorite']) && $_POST['is_favorite'] === "Y")
            {
                $is_favorite = 'Y';
            }
            else
            {
                $is_favorite = 'N';
            }
            
            // gets number of rows, incrementing as we add entries to quotes
            $id_query = "SELECT id FROM quotes";
            $id_result = mysqli_query($dbc, $id_query);
            $id = $id_result->num_rows + 1;
            
            $query = "INSERT INTO quotes (id, text, author, date_entered, favorite) VALUES ('$id', '$quote_text', '$author', '$date_entered', '$is_favorite')";
            ($dbc->query($query));
            print '<a href="quotes.php">Return to quotes</a>';
        }
    }    
    else
    {
        print 'You need to be logged in to add quotes.';      
    }


}






include('templates/footer.php');
?>