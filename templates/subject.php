<div class="col-md-4 col-sm-6 my-4">
	<div class="card m-auto event" style="width: 20rem;">
		<div class="card-body">
			<h4 class="card-title"><?php echo $r['name']; ?></h4>

			<a href="<?= $server; ?>components/exam/index.php?sub=<?= $r['id'];?>" class="btn btn-success">Start Exam</a>
		</div>
	</div>
</div>