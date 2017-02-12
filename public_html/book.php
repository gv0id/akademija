<?php include_once('../init.php'); ?>

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

<?php
if(isset($_GET['b'])) { 
	$b = mysqli_real_escape_string($db, $_GET['b']); 

	$results = mysqli_query($db, "SELECT * FROM books WHERE id = {$b}");
	if (!$results) { redirect("404.php"); } 
	else { $book = mysqli_fetch_array($results); }
}
?>

<div id="main_page">
	<div id="header_page">
		<h1>Cover To Cover Bookshop</h1>
	</div>
	<div id="content_page">
		<center><h2><?php echo "{$book['book_name']} by {$book['book_author']} ({$book['book_year']})"; ?> </h2></center>
		<hr/>
		<div id = "left_side">
			<a href="<?php echo "{$book['book_link']}" ?>" target="_blank"><img src="img/<?php echo "{$b}"; ?>.jpg" style="width: 300px;height: 100%;"></a>
		</div>
		<div id = "right_side">
			<?php echo "{$book['book_synopsis']}"; ?>
		</div>
			<hr /> <br />
		<center><a class="btn" href="index.php<?php echo $_SESSION["curPage"]; $_SESSION["curPage"] = 0; ?>"> Go Back</a></center>
	</div>
	<div id="footer_page">
		<p>&copy; <?php echo date('Y'); ?> gVoid ALL RIGHTS RESERVED</p>
	</div>
</div>

</body>
</html>