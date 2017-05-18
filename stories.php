<?php

include('templates/header.php');

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{
    $spacing_counter = 0;
    $user_directory = "uploads/" . $_SESSION['username'] . "/";
    $file_list = scandir($user_directory);

    print "<h4>" . $_SESSION['username'] . '\'s Stories Uploaded</h4>';
    print '<table cellpadding="2" cellspacing="2" align="left">
            <tr> <th>Name</th> <th>Size</th> </tr>';

    foreach ($file_list as $item) 
    {
        if ( (is_file($user_directory . '/' . $item)) AND (substr($item, 0, 1) != '.') ) 
        {
            $fs = filesize($user_directory . '/' . $item);
            $lm = date('F j, Y', filemtime($user_directory . '/' . $item));
            print " <tr>
                        <td><a href='$user_directory$item'>$item</a></td>
                        <td>$fs bytes</td>
                        <td>$lm</td>
                    </tr>\n";
            $spacing_counter+=2;
        }
    }
    print '</table>';             
}
else
{
    print 'You must be logged in to see this page';
}
while($spacing_counter > 0)
{
    print "<p>&nbsp;</p>";
    $spacing_counter--;
}

include('templates/footer.php');
?>