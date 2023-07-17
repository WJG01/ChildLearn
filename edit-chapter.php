<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
</html>

<?php  
 require 'config.php';
 if(isset($_POST["id"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM course_chapter WHERE chapter_id = '".$_POST["id"]."'";  
      $result = mysqli_query($conn, $query);  
      $output .= '  
      <div class="edit">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
                <div class="form-group">
                    <input type = "hidden" value = "'.$row['chapter_id'].'" id = "id">
                    <label>Chapter</label> <input type="number" value="'.$row["chapter_order"].'" class="quiz-number" readonly min="1" max="10" id="chapter_order" name="chapter_order" required>
                </div>
                <div class="form-group">
                    <label>Chapter Title</label>
                    <input type="text" name="chapter_title" value="'.$row["chapter_title"].'" id="chapter_title" required class="form-control" />
                </div>
                <div class="form-group">
                    <label>Content Text</label>
                    <textarea rows="5" name="content_text" id="content_text" required class="form-control" >'.$row["content_text"].'</textarea>
                </div>
            </div>';  
      }  
      $output .= "</div>";  
      echo $output;  
 }  
 ?>