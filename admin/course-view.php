<?php 
include("admin-session.php");
require 'conn.php'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stylesheets/student-signups.css">
        <link rel="icon" type="image/png" href="Images/skillsoft-favicon.png">
        <?php include('header.php') ?>
        <title>Admin Course Page</title>
    </head>
    <body>
        <?php include("admin-nav.php");?>
        <div style="margin-left: 170px;" class="container-fluid admin">
        <?php 
			$id = mysqli_real_escape_string($conn,$_GET['id']);
	        $qry = "SELECT * FROM course where course_id = $id";
			$result = mysqli_query($conn, $qry);
			$row = mysqli_fetch_array($result);
			$qid = $row['course_id'];
        ?>
		<div class="col-md-12 alert alert-warning"><?php echo $row['course_title'] ?></div>
		<button class="btn btn-warning bt-sm" id="new_question"><i class="fa fa-plus"></i> Add Chapters</button>
		<br>
		<br>
		<div id="table-data" class="card col-md-12 mr-4" style="float:left">
			<div class="card-header">
				Chapters
			</div>
			<div class="card-body">
				<ul class="list-group">
				<?php
					$qry = $conn->query("SELECT * FROM course_chapter where course_id = ".$_GET['id']." ORDER BY chapter_order ASC");
                    while($row=$qry->fetch_array()){
						$id = $row['chapter_id'];
						?>
						<li class="list-group-item"><?php echo $row['chapter_order'] ?>. <?php echo $row['chapter_title'] ?><br>
							<center>
								<button class="btn btn-sm btn-outline-primary edit_question" id="<?php echo $row['chapter_id']?>" type="button"><i class="fa fa-edit"></i></button>
								<button class="btn btn-sm btn-outline-danger remove_question" data-id="<?php echo $row['chapter_id']?>" type="button"><i class="fa fa-trash"></i></button>							
							</center>
						</li>
				<?php
					}
				?>
				</ul>
			</div>
		</div>

		<?php 
			$query = $conn->query("SELECT MAX(chapter_order) FROM `course_chapter` WHERE course_id = ".$_GET['id']."");
			while($row=$query->fetch_array()){
			$cur_auto_id = $row['MAX(chapter_order)'] + 1;
        ?>
	
		<div class="modal fade" id="manage_question" tabindex="-1" role="dialog" >
			<div class="modal-dialog modal-centered" role="document">
				<div style="width: 100%;" class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModallabel">Add New Chapters</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form action="uploadchapter.php" method="POST" id='question-frm' enctype="multipart/form-data">
						<div class ="modal-body" id="edit-question">
							<div id="msg"></div>
							<div class="form-group">
								<label>Chapter</label> <input type="number" value="<?php echo $cur_auto_id ?>" class="quiz-number" min="1" max="10" name="chapter_order" readonly required>
								<input type="hidden" name="qid" value="<?php echo $_GET['id'] ?>" />
								<?php
									}
								?>
							</div>
                            <div class="form-group">
                                <label>Chapter Title</label>
                                <input type="text" name="chapter_title" required class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Content Text</label>
                                <textarea rows='3' name="content_text" required class="form-control" ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Chapter Cover Image</label>
                                <input type="file" required accept="image/*,.png,.jpeg,.jpg" name="image">
                            </div>
                            <div class="form-group">
                                <label>Chapter Content Video</label>
                                <input type="file" required accept="video/mp4" name="video">
                            </div>
						</div>
						<div class="modal-footer">
							<button type="submit" name="insert-chapter" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Save</button>
							<input type="hidden" value="<?php echo $qid; ?>" name="course_id">
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="dataModal" class="modal fade">  
            <div class="modal-dialog">  
              <div style="width: 100%" class="modal-content">  
                <div class="modal-header">  
                    <?php echo '<h4 align="center" class="modal-title">Edit Chapter</h4>';?>
                </div>  
                <div class="modal-body" id="edit_ques"></div>  
              <div class="modal-footer">   
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                <div id="target">
                  <a href="" id = "update_chapter" class="btn btn-success">Confirm Changes</a>
                </div>
              </div>  
            </div>  
        </div>

		
			
    <script>
	$(document).ready(function(){
		$('#table').DataTable();
		$('#new_question').click(function(){
			$('#msg').html('')
			$('#manage_question .modal-title').html('Add New Chapter')
			$('#manage_question #question-frm').get(0).reset()
			$('#manage_question').modal('show')
		})

		$('.edit_question').click(function(){
			var id = $(this).attr('id')
			$.ajax({
				url:"edit-chapter.php",  
                method:"post",  
                data:{id:id},
				success:function(data){
					$('#edit_ques').html(data);  
                    $('#dataModal').modal("show"); 
				}
			})
		})

		$('#update_chapter').click(function(event){
        var chapter_title   = $("#chapter_title").val();
        var content_text 	= $("textarea#content_text").val();
        var id 			    = $("#id").val();
			$.ajax({
			url:'updatechapter.php',
			method:'post',
			data: {
					'chapter_title' : chapter_title,
					'content_text' 	: content_text,
					'id'            : id
				},
			success:function(response){
				if(response == true)
					location.reload()
					alert( "Chapter has been successfully edited!" );
				}
			});
      	});

		$('.remove_question').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure you want to delete this chapter?');
			if(conf == true){
				$.ajax({
				url:'../delete-chapter.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
						alert( "Chapter has been successfully deleted!" );
					}
				})
			}
		})
	})
</script>
    </body>
</html>