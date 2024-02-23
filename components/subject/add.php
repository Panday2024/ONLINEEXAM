<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/online-exam/";

require_once($path . 'connect.php');

// Initialize the session
session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['type'] == 'examiner')) {
	echo "Unauthorized Access";
	return;
}

if (isset($_POST) & !empty($_POST)) {
	$name = ($_POST['name']);
	
	// Execute query
	$query = "INSERT INTO `subjects` (name) VALUES ('$name')";
	$res = mysqli_query($connection, $query);
	if ($res) {
		header('location: view.php');
	} else {
		$fmsg = "Failed to Insert data.";
		print_r($res);
		// print_r($res->error_list);
	}
}
?>

<?php require_once($path . 'templates/header.php') ?>

<div class="container">
	<?php if (isset($fmsg)) { ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
	<h2 class="my-4">Add New Subject</h2>

	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="" required />
		</div>
		<input type="submit" class="btn btn-primary" value="Add Subject" />
	</form>


</div>

<?php require_once($path . 'templates/footer.php') ?>