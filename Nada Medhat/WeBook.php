
<!DOCTYPE html>

<html>

<head>

    <title>Image Upload in PHP</title>
    <link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body>
    <div class="center">
        <h3> Search for Books </h3>

        <form method="GET" action="" enctype="multipart/form-data">

            <label for="title">Title:</label><br>
            <input type="text" id="bookTitle" name="Title" autofocus><br>

            <p> Or </p>

            <label for="author">Author Name:</label><br>
            <input type="text" id="AuthorName" name="Aname"><br><br>

            <button type="submit" name="Search">

                Search

            </button>

        </form>
    </div>

    <hr>

    <div class="center"> 

        <h3> Uploading image </h3>

    </div>

    <div id="wrapper">
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="file" name="choosefile" value="" />

            <div>

                <button type="submit" name="uploadfile">

                UPLOAD

                </button>

            </div>

        </form>

    </div>

</body>

</html>
<?php

error_reporting(0);

?>

<?php

$msg = ""; 
$db = mysqli_connect("localhost", "root", "", "WeBook"); 
if (isset($_POST['uploadfile'])) {

    $filename = $_FILES["choosefile"]["name"];

    $tempname = $_FILES["choosefile"]["tmp_name"];  

        $folder = "image/".$filename;   

        $sql = "INSERT INTO Books (image) VALUES ('$filename')";

        mysqli_query($db, $sql);       

        if (move_uploaded_file($tempname, $folder)) {

            $msg = "Image uploaded successfully";

        }else{

            $msg = "Failed to upload image";

    }

}
if (isset($_GET['Search'])) {
    $title = $_FILES["Title"]["name"];
    $Aname = $_FILES["Aname"]["name"];
    if($title != NULL) {
        $sql = "SELECT * FROM Books WHERE Title = '$title'";
    }
    else if($Aname != NULL) {
        $sql = "SELECT * FROM Books WHERE AuthorName = '$Aname'";
    }
    else{
        ptintf("Please enter a title of author name to search for books");
    }
    $results = mysqli_query($db, $sql);       
    foreach ($results as $row) {
        printf(
        "<table class='table container mt-4'>
        <thead>
            <tr>
                <th scope='col'>Title</th>
                <th scope='col'>Author Name</th>
                <th scope='col'>Image</th>
                <th scope='col'>Description</th>
                <th scope='col'>Publication Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>
        </tbody>
        </table>",
            htmlspecialchars($row["Title"], ENT_QUOTES),
            htmlspecialchars($row["AuthorName"], ENT_QUOTES),
            htmlspecialchars($row["Image"], ENT_QUOTES),
            htmlspecialchars($row["Description"], ENT_QUOTES),
            htmlspecialchars($row["PublicationDate"], ENT_QUOTES)
        );
    }
}

$result = mysqli_query($db, "SELECT * FROM image");

?>
