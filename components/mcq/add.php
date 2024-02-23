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
	$question = ($_POST['question']);

	$choiceArray = array($_POST['choice1'], $_POST['choice2'], $_POST['choice3'], $_POST['choice4']);
	$choices = json_encode($choiceArray);

	$answer = ($_POST['answer']);
	$subject_id = ($_POST['subject_id']);

	// Execute query
	$query = "INSERT INTO `mcq` (question, choices, answer, subject_id) VALUES ('$question', '$choices', '$answer', '$subject_id')";
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
	<h2 class="my-4">Add New Question</h2>

	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Question</label>
			<input type="text" class="form-control" name="question" value="" required />
		</div>
		<div class="form-group">
			<label>Choices</label>
			<ul class="list-group">
				<li class="list-group-item d-flex align-items-center">
					1. <input type="text" class="form-control ml-2" name="choice1" value="" required />
				</li>
				<li class="list-group-item d-flex align-items-center">
					2. <input type="text" class="form-control ml-2" name="choice2" value="" required />
				</li>
				<li class="list-group-item d-flex align-items-center">
					3. <input type="text" class="form-control ml-2" name="choice3" value="" required />
				</li>
				<li class="list-group-item d-flex align-items-center">
					4. <input type="text" class="form-control ml-2" name="choice4" value="" required />
				</li>
			</ul>
		</div>
		<div class="form-group">
			<label>Correct Answer</label>
			<select name="answer" class="custom-select">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
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
					<option value="<?= $subject['id']; ?>"><?= $subject['name']; ?></option>
				<?php } ?>
			</select>
		</div>
		<input type="submit" class="btn btn-primary" value="Add Question" />
	</form>


</div>

<?php require_once($path . 'templates/footer.php') ?>