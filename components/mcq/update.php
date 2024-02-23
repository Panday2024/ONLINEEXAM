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

$SelSql = "SELECT * FROM `mcq` WHERE id=$id";
$res = mysqli_query($connection, $SelSql);
$r = mysqli_fetch_assoc($res);

$choicesJSON = json_decode($r['choices']);

if (isset($_POST) & !empty($_POST)) {
	$question = ($_POST['question']);

	$choiceArray = array($_POST['choice1'], $_POST['choice2'], $_POST['choice3'], $_POST['choice4']);
	$choices = json_encode($choiceArray);

	$answer = ($_POST['answer']);
	$subject_id = ($_POST['subject_id']);

	// Execute query
	$query = "UPDATE `mcq` 
		SET question='$question', choices='$choices', answer='$answer', subject_id='$subject_id' 
		WHERE id='$id'";

	$result = mysqli_query($connection, $query); // get result
	if ($result) {
		header('location: view.php');
	} else {
		$fmsg = "Failed to Insert data.";
		print_r($result);
	}
}
?>

<?php require_once($path . 'templates/header.php') ?>

<div class="container">
	<?php if (isset($fmsg)) { ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>

	<h2 class="my-4">Update MCQ</h2>
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Question</label>
			<input type="text" class="form-control" name="question" value="<?php echo $r['question']; ?>" required />
		</div>

		<div class="form-group">
			<label>Choices</label>
			<ul class="list-group">
				<?php
				for ($j = 0; $j < 4; $j++) {
				?>
					<li class="list-group-item d-flex align-items-center">
						<?= $j + 1; ?>. <input type="text" class="form-control ml-2" name="choice<?= $j + 1; ?>" value="<?= $choicesJSON[$j]; ?>" required />
					</li>
				<?php } ?>
			</ul>
		</div>
		<div class="form-group">
			<label>Correct Answer</label>
			<select name="answer" class="custom-select">
				<?php
				for ($k = 0; $k < 4; $k++) {
				?>
					<option value="<?= $k + 1; ?>" <?= $r['answer'] == ($k + 1) ? "selected" : ""; ?>>
						<?= $k + 1; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label for="subjectId">Choose a Subject:</label>
			<select name="subject_id" class="custom-select" id="subjectId">
				<?php
				$readSubjects = "SELECT * FROM `subjects`";
				$queryResult = mysqli_query($connection, $readSubjects);

				while ($subject = mysqli_fetch_assoc($queryResult)) {
				?>
					<option value="<?= $subject['id']; ?>" <?= $r['subject_id'] == $subject['id'] ? "selected" : ""; ?>>
						<?= $subject['name']; ?>
					</option>
				<?php } ?>
			</select>
		</div>

		<input type="submit" class="btn btn-primary" value="Update" />
	</form>
</div>

<?php require_once($path . 'templates/footer.php') ?>