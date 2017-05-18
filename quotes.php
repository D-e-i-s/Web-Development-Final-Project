<?php
include('templates/header.php');

print '<h2>Quotes</h2>';

if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
{

    if(isset($_SESSION['loggedIn']))
    {
        print '<h3><a href="add_quote.php">Add New Quote</a><br><br></h3>';
        
        
        
        $query = 'SELECT * FROM quotes';
        $result = mysqli_query($dbc, $query);
        
        while ($row = $result->fetch_array(MYSQLI_BOTH)) 
        {
            // Will use to provide id for Edit and Delete links
            $id = "{$row['id']}";
            
            print   "{$row['text']} <br>
                    <br>
                    -{$row['author']} &nbsp
            ";
            if( $row['favorite'] === 'Y')
            {
                    echo "<span style='color:green; font-weight: bold'>Favorite!</span>";
            }
            print ' <br>
                    <a href=update_quote.php?id=' . $id . '>Edit</a> &nbsp <a href=delete_quote.php?id=' . $id . '>Delete</a><br>
                    <br>
                    <br>
            ';
            // {$row['id']}
                    
        }
    }    
    else
    {
        $query = 'SELECT * FROM quotes';
        $result = mysqli_query($dbc, $query);
        
        while ($row = $result->fetch_array(MYSQLI_BOTH)) 
        {
            print   "{$row['text']} <br>
                    <br>
                    -{$row['author']} &nbsp
            ";
            if( $row['favorite'] === 'Y')
            {
                    echo "<span style='color:green; font-weight: bold'>Favorite!</span><br><br><br>";
            }
        }
    }

}

include('templates/footer.php');
?>