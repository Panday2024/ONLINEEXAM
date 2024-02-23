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

$id = $_GET['id'];

$SelSql = "SELECT * FROM `subjects` WHERE id=$id";
$res = mysqli_query($connection, $SelSql);
$r = mysqli_fetch_assoc($res);


if (isset($_POST) & !empty($_POST)) {
	$name = ($_POST['name']);
	
	// Execute query
	$query = "UPDATE `subjects` SET name='$name' WHERE id='$id'";

	$res = mysqli_query($connection, $query); // get result
	if ($res) {
		header('location: view.php');
	} else {
		$fmsg = "Failed to Insert data.";
		// print_r($res);
	}
}
?>

<?php require_once($path . 'templates/header.php') ?>

<div class="container">
	<?php if (isset($fmsg)) { ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
	
	<h2 class="my-4">Update Subject</h2>
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="<?php echo $r['name']; ?>" required />
		</div>

		<input type="submit" class="btn btn-primary" value="Update" />
	</form>
</div>

<?php require_once($path . 'templates/footer.php') ?>