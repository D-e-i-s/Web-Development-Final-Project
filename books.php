<?php

include('templates/header.php');

if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
{
    if(isset($_SESSION['loggedIn']))
    {
        $current_user = $_SESSION['username'];
        $user_directory = "uploads/" . $_SESSION['username'] . "/";
        
        print   "<form method='POST'>
                   Book Title: <input type='text' style='width:25%' name='book_title' required><br>
                   <br>
                   Book Author: <input type='text' style='width:25%' name='book_author' required><br>
                   <br>
                   <input type='submit' value='Add Book' name='submit'>
                </form>
        ";

        //Change so that below shows only books for current user
        print "<h3>" . $current_user . "'s Books</h3> <br>";
        
        if(file_exists("uploads/" . $_SESSION['username'] . "/books.csv"))
        {
            $user_file = fopen("uploads/" . $_SESSION['username'] . '/books.csv', 'r');
            while (!feof($user_file) ) 
            {
                $line_of_text = fgetcsv($user_file, 1024, '|');
                
                if($line_of_text !== '')
                {
                    $current_line = $line_of_text[0] . " by " . $line_of_text[1]. "<br>";
                    if($current_line != " by " . "<br>")
                    {
                        print "<li>" . $current_line . "</li>";
                    }
                }
            }
            fclose($user_file);
        }
        else
        {
            print 'The file does not exist.';
        }
        
        //http://stackoverflow.com/questions/518795/dynamically-display-a-csv-file-as-an-html-table-on-a-web-page
        
        
        //read up on parameterized SQL
        //https://www.w3schools.com/php/php_mysql_prepared_statements.asp
        
        //HTML to reimplement after file reading taken care of
        /*
                <ul>
                    <li>The Catcher in the Rye</li>
                    <li>Nine Stories</li>
                    <li>Franny and Zooey</li>
                    <li>Raise High the Roof Beam, Carpenters and Seymour: An Introduction</li>
                </ul>
         */

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $title = $_POST['book_title'];
            $author = $_POST['book_author'];
            
            $user_file = fopen("uploads/" . $_SESSION['username'] . '/books.csv', 'a');
            fwrite($user_file, $title . "|" . $author . "\r\n");
            fclose($user_file);
        }
    }
    else
    {
        print 'You need to be logged in to have a book list.';
    }
}
include('templates/footer.php');

?>