<?php
include("teacher-session.php");
require 'config.php';
include("awsCode/S3operation.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="stylesheets/stud-signup.css">
	<link rel="icon" type="image/png" href="Images/skillsoft-favicon.png">
	<?php include('header.php') ?>
	<title>Teacher Course Page</title>
	<!-- <style>
			.dataTables_filter{ display: none; }
		</style> -->
</head>

<body>
	<?php include("teacher-navi.php"); ?>
	<div style="margin-left: 170px;" class="container-fluid admin">
		<div class="col-md-12 alert alert-warning">Course List</div>
		<button class="btn btn-warning bt-sm" id="new_quiz"><i class="fa fa-plus"></i> Add New</button>
		<br>
		<br>
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered" id='table'>
					<thead>
						<tr>
							<th>Course ID</th>
							<th>Course Title</th>
							<th>Course Category</th>
							<th>Course Description</th>
							<th>Course Create Date</th>
							<th>Total Chapters</th>
							<th>Course Cover</th>
							<th style="width: 20%;">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tid = $_SESSION['teach_id'];
						$qry = $conn->query("SELECT course.teac_id, course.course_id, course.course_title, course.course_category, course.course_cover, course.course_description, course.course_create_date, count(*) FROM course LEFT JOIN course_chapter ON (course.course_id = course_chapter.course_id) WHERE course.teac_id = '$tid' GROUP BY course.course_id");

						$i = 1;
						if ($qry->num_rows > 0) {
							while ($row = $qry->fetch_assoc()) {
								$items = $conn->query("SELECT count(chapter_id) as item_count from course_chapter where course_id = '" . $row['course_id'] . "'")->fetch_array()['item_count'];
						?>
								<tr>
									<td><?php echo $i ?></td>
									<td><?php echo $row['course_title'] ?></td>
									<td><?php echo $row['course_category'] ?></td>
									<td><?php echo $row['course_description'] ?></td>
									<td><?php echo $row['course_create_date'] ?></td>
									<td><?php echo $items ?></td>
									<td>
										<img class="quiz-cover-pic" src="<?php echo getMediaFromS3($row['course_cover']); ?>" alt="Course cover picture" style="max-width: 100px; max-height: 100px; object-fit: contain;">
									</td>

									<td>
										<center>
											<a class="btn btn-sm btn-outline-primary edit_quiz" href="./course-view.php?id=<?php echo $row['course_id'] ?>"><i class="fa fa-task"></i> Manage</a>
											<button class="btn btn-sm btn-outline-primary editbtn" data-course-id="<?php echo $row['course_id'] ?>" type="button"><i class="fa fa-edit"></i> Edit</button>
											<button class="btn btn-sm btn-outline-danger remove_quiz" data-id="<?php echo $row['course_id'] ?>" type="button"><i class="fa fa-trash"></i> Delete</button>
										</center>
									</td>
								</tr>

						<?php
								$i++;
							}
						}
						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal fade" id="manage_quiz" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-centered" role="document">
			<div style="width: 100%;" class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModallabel">Add New Course</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form method="POST" action="insert-course.php" id='quiz-frm' enctype="multipart/form-data">
					<div class="modal-body">
						<div id="msg"></div>
						<div class="form-group">
							<label>Course Title</label>
							<input type="hidden" value="<?php echo $tid ?>" name="tid" />
							<input type="hidden" name="id" />
							<input type="text" name="course_title" required class="form-control" />
						</div>
						<div class="form-group">
							<label>Course Category</label>
							<input type="text" name="course_category" required class="form-control" />
						</div>
						<div class="form-group">
							<label>Course Description</label>
							<textarea rows='3' name="course_description" required class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label>Course Cover Image</label>
							<input type="file" required accept="image/*,.png,.jpeg,.jpg" name="image">
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" value="<?php echo date("Y-m-d h:i:s"); ?>" name="course_create_date">
						<button type="submit" class="btn btn-success" name="insert-course"><span class="glyphicon glyphicon-save"></span> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit_quiz" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-centered" role="document">
			<div style="width: 100%;" class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModallabel">Edit Course</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form method="POST" action="update-course.php" id='quiz-frm' enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label>Course Title</label>
							<input type="hidden" name="update_id" id="update_id" />
							<input type="text" name="course_title" id="course_title" required class="form-control" />
						</div>
						<div class="form-group">
							<label>Course Category</label>
							<input type="text" id="course_category" name="course_category" required class="form-control" />
						</div>
						<div class="form-group">
							<label>Course Description</label>
							<textarea rows='3' name="course_description" id="course_description" required class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label>Course Cover</label>
							<input type="file"  accept="image/*,.png,.jpeg,.jpg" name="image">
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" value="<?php echo date("Y-m-d h:i:s"); ?>" name="course_create_date">
						<button type="submit" class="btn btn-primary" name="update-course"><span class="glyphicon glyphicon-save"></span>Update Course</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>

<script>
	$(document).ready(function() {
		$('#table').DataTable();
		$('#new_quiz').click(function() {
			$('#msg').html('')
			$('#manage_quiz .modal-title').html('Add New Course')
			$('#manage_quiz #quiz-frm').get(0).reset()
			$('#manage_quiz').modal('show')
		})

		$(document).on("click", ".editbtn", function() {
			$('#edit_quiz').modal('show');
			var course_id = $(this).data("course-id");
			var course_title = $(this).closest('tr').find("td:nth-child(2)").text();
			var course_category = $(this).closest('tr').find("td:nth-child(3)").text();
			var course_description = $(this).closest('tr').find("td:nth-child(4)").text();

			console.log(course_id, course_title, course_category, course_description);

			$('#update_id').val(course_id);
			$('#course_title').val(course_title);
			$('#course_category').val(course_category);
			$('#course_description').val(course_description);
		});

		$(document).on("click", ".remove_quiz", function() {
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure you want to delete this course?');
			if (conf == true) {
				$.ajax({
					url: './delete-course.php?id=' + id,
					error: err => console.log(err),
					success: function(resp) {
						if (resp == true)
							location.reload()
						alert("Course has been successfully deleted!");
					}
				})
			}
		})
	})
</script>

</html>