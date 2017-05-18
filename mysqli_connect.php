<?php

if ($dbc = @mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub'))
{
    print 'You have successfully connected to the database.';
    

    
    
    mysqli_close($dbc);
}
else 
{
    print 'You have failed to connect to the database.';
}
// must close conenction at end of any process that accesses it

?>