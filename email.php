<?php
    require 'phpmailer/PHPMailerAutoload.php';
    include('templates\header.php');

    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
    {
        echo '<h2>Email Form</h2> <br>
        <form method="post">
            My Email: <input type="email" style="width:30em" name="email" required>
            <br><br>
            Subject: <input type=text" style="width:30em" name="subject" required>
            <br><br>
            Message: <br>
            <textarea style="height:16em; width:35em" name="message"></textarea>
            <br><br>
            <input type="submit" value="Submit" name="submit">   
        </form>';
    }
    else
    {
        print 'You must be logged in to see this page';
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        //$mail->SMTPDebug = 3; //show debug details

        include ('config.php');

        $mail->addAddress('spoll3@uis.edu');
        $mail->FromName = $_POST['email'];
        $mail->Subject = $_POST['subject'];
        $mail->Body = $_POST['message'];

        if(!$mail->send())
        {
            print '<h3 style="color:red;">ERROR! Unable to send Email<h3>';
        }
        else
        {
            print '<h3 style="color:green;">Email sent successfully</h3>';
        }
    }

    include('templates\footer.php');
?>
