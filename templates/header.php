<?php
session_start();
// turns on output buffering
ob_start();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="HandheldFriendly" content="True">
    
    <title>Tech-Singularity</title>

    <link rel="stylesheet" type="text/css" media="screen" href="css/concise.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/masthead.css" />
</head>

<body>

<header container class="siteHeader">
    <div row>
    <h1 column=4 class="logo"><a href="index.php">Techify your life!</a></h1>
        <nav column="8" class="nav">
            <ul>
                <li><a href="books.php">Books</a></li>
                <li><a href="quotes.php">Quotes</a></li>
                <?php
                if(isset($_SESSION['loggedIn']))
                {
                    if ($_SESSION["loggedIn"] === true)
                    {
                        print '<li><a href="stories.php">Stories</a></li>';
                        print '<li><a href="email.php">Contact</a></li>';
                        print '<li><a href="upload.php">Upload</a></li>';
                        if(isset($_SESSION['is_admin']))
                        {
                            if($_SESSION['is_admin'] === 1)
                            {
                                print '<li><a href="admin.php">Admin</a></li>';
                            }
                        }
                        print '<li><a href="logout.php">Logout</a></li>';
                    }
                }
                else
                {
                    print '<li><a href="login.php">Login</a></li>';
                    print '<li><a href="register.php">Register</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>

<main container class="siteContent">
    <!-- BEGIN CHANGEABLE CONTENT. -->
        <!-- Script 8.2 - header.php -->