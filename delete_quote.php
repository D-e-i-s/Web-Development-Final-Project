<?php
include('templates/header.php');

if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
{
    if(isset($_SESSION['loggedIn']))
    {
        print '<p> Are you sure you want to delete this quote? <br><br><br>';
        
        $id_num = $_GET['id'];

        $query = "SELECT text, author, favorite FROM quotes WHERE id = '$id_num'";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        
        print   "{$row['text']} <br>
                <br>
                -{$row['author']} &nbsp
            ";
        if( $row['favorite'] === 'Y')
        {
                echo "<span style='color:green; font-weight: bold'>Favorite!</span>";
        }
        
        print '<form method="post">
               <input type="submit" value="Delete Quote" name="submit"
               
        ';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $query = "DELETE FROM quotes WHERE id = $id_num";
            if($dbc->query($query) === TRUE)
            {
                print "The quote was deleted successfully.";
            }
            else
            {
                echo "Error deleting record: " . $dbc->error;
            }
        }
    }
    else
    {
        print "You must be logged in to delete quotes.";
    }
}
include('templates/footer.php');
?>