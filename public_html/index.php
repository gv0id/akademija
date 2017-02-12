<?php include_once('../init.php'); ?>
<?php $_SESSION["curPage"] = ''; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset=utf-8>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link rel="stylesheet" href="css/main.css">
<link href='http://fonts.googleapis.com/css?family=Orbitron:900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nunito:700' rel='stylesheet' type='text/css'>

<title>Cover to Cover Bookshop</title>

</head>
<body>

<style>  
    tr:nth-child(even) { background: #89b2f4; }
</style>

<?php if(isset($_GET['s'])) {

    $getSort = htmlspecialchars($_GET['s']);
    $_SESSION["sort"] = '&s=' . $getSort; 
    
    if(($getSort) == '1d')     { $id = "book_name DESC"; }
    elseif(($getSort) == '1a') { $id = "book_name ASC"; }
    elseif(($getSort) == '2d') { $id = "book_year DESC"; }
    elseif(($getSort) == '2a') { $id = "book_year ASC"; }
    elseif(($getSort) == '3d') { $id = "book_author DESC"; }
    elseif(($getSort) == '3a') { $id = "book_author ASC"; }
    elseif(($getSort) == '4d') { $id = "book_genre DESC"; }
    elseif(($getSort) == '4a') { $id = "book_genre ASC"; }

} else { $id = 'book_name ASC'; } ?>

<div id="main_page">
    <div id="header_page">
        <h1>Welcome to Cover To Cover Bookshop!</h1>
    </div>
    <div id="content_page">
        <center><h2>This week's list of books</h2></center>
        <form action="" method="POST">
            <input type="text" name="query" />
            <input type="submit" name = "submit" value="Search" />
        </form>
        <?php if($_SESSION["sort"]) { echo '<p style="text-align: right; padding: 0 16px 0 0;"><a href="filters.php"> <img src="img/x.png"> Remove Filters</a></p>'; } ?>

<?php

    if(isset($_POST['submit'])) {

    $query = $_POST['query']; 
    $min_length = 3;

    if(strlen($query) >= $min_length){
        $query = mysqli_real_escape_string($db, $query);
        $raw_results = mysqli_query($db, "SELECT * FROM books WHERE (`book_name` LIKE '%".$query."%') OR (`book_year` LIKE '%".$query."%') OR (`book_author` LIKE '%".$query."%') OR (`book_genre` LIKE '%".$query."%') OR (`book_synopsis` LIKE '%".$query."%')") or die(mysqli_error($db));

        if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
            echo '<table border = "0" style="width: 100%; text-align: center;">';
            echo '
            <tr>
                <th>Name <a href="index.php?s=1a"><img src="img/asc.ico"></a> <a href="index.php?s=1d"><img src="img/des.ico"></a></th>
                <th>Year <a href="index.php?s=2a"><img src="img/asc.ico"></a> <a href="index.php?s=2d"><img src="img/des.ico"></a></th>
                <th>Author(s) <a href="index.php?s=3a"><img src="img/asc.ico"></a> <a href="index.php?s=3d"><img src="img/des.ico"></a></th>
                <th>Genre <a href="index.php?s=4a"><img src="img/asc.ico"></a> <a href="index.php?s=4d"><img src="img/des.ico"></a></th>
            </tr>';
            while($results = mysqli_fetch_array($raw_results)){             
                echo "<tr><td><a href='book.php?b={$results['id']}'>{$results['book_name']}</a></td><td><b>{$results['book_year']}</b></td><td>{$results['book_author']}</td><td>{$results['book_genre']}</td></tr>";
            }
            echo "</table><br /><center><a class=\"btn\" href=\"index.php\"> Go Back</a></center>"; 
        }
        else{ echo "<h2>No results.</h2> <br /> <center><a class=\"btn\" href=\"index.php\"> Go Back</a></center>"; }
    }
    else { echo "<h3>Please try again. Minimum search length is {$min_length}.</h3><center><a class=\"btn\" href=\"index.php\"> Go Back</a></center>"; }
} else {

?>
        <hr/>
<?php

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 20; // Set how many records do you want to display per page.
$startpoint = ($page * $per_page) - $per_page;

$results = mysqli_query($db, "SELECT * FROM books ORDER by {$id} LIMIT {$startpoint} , {$per_page}");

if (!$results) { redirect("404.php"); } else { ?>

<table border = "0" style="width: 100%; text-align: center;">
    <tr>
        <th>Name <a href="index.php?s=1a"><img src="img/asc.ico"></a> <a href="index.php?s=1d"><img src="img/des.ico"></a></th>
        <th>Year <a href="index.php?s=2a"><img src="img/asc.ico"></a> <a href="index.php?s=2d"><img src="img/des.ico"></a></th>
        <th>Author(s) <a href="index.php?s=3a"><img src="img/asc.ico"></a> <a href="index.php?s=3d"><img src="img/des.ico"></a></th>
        <th>Genre <a href="index.php?s=4a"><img src="img/asc.ico"></a> <a href="index.php?s=4d"><img src="img/des.ico"></a></th>
    </tr>

<?php

while ($row = mysqli_fetch_array($results)) {
    echo "<tr><td><a href='book.php?b={$row['id']}'>{$row['book_name']}</a></td><td><b>{$row['book_year']}</b></td><td>{$row['book_author']}</td><td>{$row['book_genre']}</td></tr>"; 
    } 
?>

</table>

<?php } }
    echo pagination($per_page,$page,$url='?'); ?>
    </div>
    <div id="footer_page">
        <p>&copy; <?php echo date('Y'); ?> gVoid ALL RIGHTS RESERVED</p>
        <?php if($_SERVER['QUERY_STRING']) { $_SESSION["curPage"] = '?' . $_SERVER['QUERY_STRING']; } ?>        
    </div>
</div>

</body>
</html>