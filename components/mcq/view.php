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

$ReadSql = "SELECT * FROM `mcq`";
$res = mysqli_query($connection, $ReadSql);

?>

<?php require($path . 'templates/header.php') ?>
<div class="container-fluid my-4">
	<div class="row my-2">
		<h2>Online Exam Management System - Multiple Choice Questions</h2>
		<a href="add.php"><button type="button" class="btn btn-primary ml-4 pl-2">Add New</button></a>
	</div>
	<table class="table ">
		<thead>
			<tr>
				<th>No.</th>
				<th>Question</th>
				<th>Choices</th>
				<th>Answer</th>
				<th>Subject</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($r = mysqli_fetch_assoc($res)) {
			?>
				<tr>
					<th scope="row"><?php echo $r['id']; ?></th>
					<td><?php echo $r['question']; ?></td>
					<td><?php
						$arr = json_decode($r['choices']);

						for ($i = 0; $i < 4; $i++) {
							echo $arr[$i] . ($i != 3 ? ', ' : '');
						}

					?></td>
					<td><?php echo $arr[$r['answer'] - 1]; ?></td>
					<td><?php
						$sub_id = $r['subject_id'];
						$readSubjects = "SELECT * FROM `subjects` where id=$sub_id";
						$queryResult = mysqli_query($connection, $readSubjects);
						if ($subject = mysqli_fetch_assoc($queryResult)) {
							echo $subject['name'];
						} ?>
					</td>
					<td>
						<a href="update.php?id=<?php echo $r['id']; ?>"><button type="button" class="btn btn-info">Edit</button></a>

						<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal<?php echo $r['id']; ?>">Delete</button>

						<!-- Modal -->
						<div class="modal fade" id="myModal<?php echo $r['id']; ?>" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Delete Question</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>Are you sure?</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<a href="delete.php?id=<?php echo $r['id']; ?>"><button type="button" class="btn btn-danger"> Yes, Delete</button></a>
									</div>
								</div>

							</div>
						</div>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>



<?php require($path . 'templates/footer.php') ?>