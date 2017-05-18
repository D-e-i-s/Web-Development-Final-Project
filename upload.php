<?php
    include('templates/header.php');
    
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
    {
        echo 'Upload a review of your favorite tech.  File extensions limited to .pdf, .doc, .docx, .txt';
        echo '<br><br>';
        echo '<form action="upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
                <input type="submit" value="Upload Story" name="submit">
              </form>
        ';
        
        
        if(isset($_POST["submit"]))
        {
            $file_directory = "uploads/" . $_SESSION['username'] . "/";
            $target_file = $file_directory . basename($_FILES["fileToUpload"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $uploadOk = 1;
            
            if($imageFileType != "txt" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx")
            {
                echo "This is not a valid file format.  Please choose a file with a .txt, .pdf, .doc, or .docx extension.";
            }
            else
            {
                if(!file_exists("uploads/" . $_SESSION['username'] . "/" . basename( $_FILES["fileToUpload"]["name"])))
                {
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                }
                else
                {
                    echo "You have already uploaded a file with that same name. Please rename the file before uploading.";
                }
            }
        }
        
        
    }
    else
    {
        print 'You must be logged in to see this page';
    }
    
    include('templates/footer.php');
?>