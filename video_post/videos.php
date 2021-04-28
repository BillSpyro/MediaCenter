<?php
include_once '../includes/header.php';
include_once 'video_comment_inc.php';
include_once 'video_like_inc.php';
?>

<div class="post-form--div">
<!-- basic form to post a video -->
  <form class="post-form " action="videos_inc.php" method="post" enctype="multipart/form-data">
    <p>Post Video</p>
    <hr>
    <input class="body" type="text" name="description" placeholder="text" >
    <input class="video" type="file" name="video"  required>
    <input class="submit" type="submit" name="submit" >
  </form>
</div>

  <!-- show the video here  --> 
<?php 
$query = "SELECT * FROM profile, videos WHERE videos.user_ID = profile.user_ID ORDER BY post_time DESC";
$result = $conn->query($query);
?>
<?php while ($row = $result->fetch_array()):  ?>
<div class="posts">
  <div class="post">
      <div class="header-post">   
          <div class="image">
            <img src="<?php echo $row['profile_picture'] ?>" alt="" width="100" height="100">
          </div>
          <div class="name-time">
            <p><?php echo $row["first_name"] . " " . $row["last_name"]?></p>
            <span> posted on <?php echo $row["post_time"]?></span>
          </div>
          <!-- delete and edit video only if the post is yours -->
          <?php if ($_SESSION['id'] == $row["user_ID"]):?>
            <div class="edit-delete">
            <div class="edit">
              <a class="edit-profile--link" href="update_video.php?ID=<?php echo $row["id"] ?>"><img src="https://img.icons8.com/android/24/000000/edit.png"/></a>
            </div>
            <div class="delete">
              <form action="delete_video.php" method="post">
                <input type="text" name="video_id" value="<?php echo $row["id"]?>" hidden>
                <button type='submit' name="delete_video" ><img src="https://img.icons8.com/material-sharp/24/000000/filled-trash.png"/></button>
              </form>
            </div>
          </div>
          <?php endif ?>
       </div>
       <div>
         <p><?php echo $row["description"]?></p>
         <video width="500" height="350" controls><source src="<?php echo $row["links"]?>" type=video/mp4></video>
      </div>
      

      <!-- basic video comment form  -->
      <?php $video_id = $row["id"];?>
    <div>
      <form class="comment-form" action="video_comment_inc.php" method="POST">
        <input type="text" name="videoId" value="<?php echo $video_id;?>" hidden>
        <input type='text' name='comment' placeholder="type comment" required>
        <input type='submit' name="submitcomment">
      </form>
    </div>
 
    <!-- basic form to like the video -->
    <div>
      <form action="video_like_inc.php" method="post">
        <input class="id" type="text" name="videoId" value="<?php echo $video_id?>" hidden>
        <button class="submit-button" type="submit" name="Like" ><img class="like-image" src="https://img.icons8.com/flat-round/64/000000/good-quality--v1.png"/></button>
      </form>
    </div>


    <!-- count the likes -->
    <?php
    $sql_rate_count = "SELECT COUNT(video_likes) AS NumberOfLikes FROM likes WHERE video_ID = '$video_id';"; 
    $result1 = $conn->query($sql_rate_count);
    if ($result1->num_rows > 0) {
        while($row = $result1->fetch_assoc()) {
            $NumberOfLikes = $row['NumberOfLikes'];
            }       
    }else {
        echo "0 results";
    }

    // count the comments
    $sql_count_comments = "SELECT COUNT(content) AS NumberOfComments FROM comments WHERE video_ID = '$video_id';"; 
      $TotalComment_ressult= $conn->query($sql_count_comments);
      if ($TotalComment_ressult->num_rows > 0) {
          while($row = $TotalComment_ressult->fetch_assoc()) {
              $NumberOfComments = $row['NumberOfComments'];
              }       
      }else {
          echo "0 results";
      }

// check if the user liked the video 
    $sql_isliked = "SELECT likes  FROM likes  WHERE video_ID = '$video_id' and user_id=$user_id;"; 
    $isliked_ressult= $conn->query($sql_isliked);
    if ($isliked_ressult->num_rows > 0) {
        while($row = $isliked_ressult->fetch_assoc()) {

            $isLiked = $row['likes'];
        }
    };
        
    ?>
    <!-- show total likes and comments  -->
    
    <div class="total_likes_comments">
      <div><p class="show-comments"><?php echo $NumberOfComments;?> Comments</p></div>
      <?php if(isset($isLiked) && $isLiked == 1):?>
        <div><p class="show-likes"><?php echo "You and " . ($NumberOfLikes - 1);?> others Liked</p></div>
        <?php else:?>
      <div><p class="show-likes"><?php echo $NumberOfLikes;?> Likes</p></div>
      <?php endif?>
    </div>



    <!-- get video's comment with profile pics and name-->
    <?php
    $query_comments = "SELECT profile.*, comments.* FROM profile, comments WHERE comments.user_ID = profile.user_ID and comments.video_ID = '$video_id' and comments.comment_ID is null;";
    $result2 = $conn->query($query_comments);
    ?>
    <p>all comments</p>
    <?php while ($row1 = $result2->fetch_array()):  ?>
            <?php $comment_ID = $row1["id"];?>
            <div class="comment">
                <div class="header-comment">   
                <div class="image">
                  
                        <img src="<?php echo $row1['profile_picture'] ?>" alt="" width="30" height="30">
                    </div>
                    <div class="name-time">
                        <p><?php echo $row1["first_name"] . " " . $row1["last_name"]?>  <span>commented on <?php echo $row1["posted_date"]?></span></p>
                    </div>
                    <!-- delete and edit video's comment only if the comment is yours-->
                    
                  <?php if ($_SESSION['id'] == $row1["user_ID"]):?>
                    <div class="edit-delete">
                      <div class="edit">
                        <a class="edit-profile--link" href="edit_video_comment.php?ID=<?php echo $row1["id"] ?>&videoID=<?php echo $row1["video_ID"] ?>&content=<?php echo $row1["content"]?>"><img class="edit_icon"src="https://img.icons8.com/android/24/000000/edit.png"/></a> 
                      </div>
                    <div class="delete">
                      <form action="delete_video_comment.php" method="post">
                      <input type="text" name="video_id" value="<?php echo $row1["video_ID"]?>" hidden>
                        <input type="text" name="comment_id" value="<?php echo $row1["id"]?>" hidden>
                        <button type='submit' name="delete_video_comment" ><img class="delete_icon" src="https://img.icons8.com/material-sharp/24/000000/filled-trash.png"/></button>
                      </form>
                    </div>
                  </div>
                  <?php endif ?>
                  
                </div>
                  <div class="comment-one">
                    <p class="single-comment"><?php echo $row1["content"]?></p>
                  </div>
                  <div>
                <!-- get nusted comment   -->
                <?php
                $query_nested_comments = "SELECT profile.*, comments.* FROM profile, comments WHERE comments.user_ID = profile.user_ID and comments.video_ID = '$video_id' and comments.comment_ID = '$comment_ID';";
                $result3 = $conn->query($query_nested_comments);
                ?>
                <div class="nested_comments">
                <?php while ($row3 = $result3->fetch_array()):  ?>
                  <div class="nested_comment">
                    <div class="header-comment">   
                        <div class="image">
                          <img src="<?php echo $row3['profile_picture'] ?>" alt="" width="30" height="30">
                        </div>
                        <div class="name-time">
                          <p><?php echo $row3["first_name"] . " " . $row3["last_name"]?>  <span>replyed on <?php echo $row3["posted_date"]?></span></p>
                        </div>
                        <?php if ($_SESSION['id'] == $row3["user_ID"]):?>
                    <div class="edit-delete">
                      <div class="edit">
                      
                        <a class="edit-profile--link" href="video_nested_comment/edit_video_nested_comment.php?ID=<?php echo $row3["id"] ?>&commentID=<?php echo $row3["comment_ID"] ?>&videoID=<?php echo $row3["video_ID"] ?>&content=<?php echo $row3["content"]?>"><img class="edit_icon" src="https://img.icons8.com/android/24/000000/edit.png"/></a> 
                      </div>
                    <div class="delete">
                      <form action="video_nested_comment/delete_video_nested_comment.php" method="post">
                        <input type="text" name="video_id" value="<?php echo $row3["video_ID"]?>" hidden>
                        <input type="text" name="comment_id" value="<?php echo $row3["comment_ID"]?>" hidden>
                        <input type="text" name="nested_comment_id" value="<?php echo $row3["id"]?>" hidden>
                        <button type='submit' name="delete_video_comment" ><img class="delete_icon"src="https://img.icons8.com/material-sharp/24/000000/filled-trash.png"/></button>
                      </form>
                    </div>
                  </div>
                  <?php endif ?>
                    </div>
                    <div class="comment-one">
                    <p class="single-comment"><?php echo $row3["content"]?></p>
                  </div>
                  </div>
                <?php endwhile ?>
                  </div>
                  </div>
                  <!-- video comments comment  -->
                  <div>
                  <form class="nested_comment-form" action="video_nested_comment/video_comment_comment_inc.php" method="POST">
                    <input type="text" name="videoId" value="<?php echo $row1["video_ID"];?>" hidden>
                    <input type="text" name="video_comment_ID" value="<?php echo $row1["id"];?>" hidden>
                    <input type='text' name='comment' placeholder="reply comment ... " required>
                    <input type='submit' name="submitcomment">
                  </form>
                </div>
          </div>
      <?php endwhile ?>
      </div>
      
  </div>
</div>
<?php endwhile?>




<!-- include footer page right here so we can have it  -->
<?php
include_once '../includes/footer.php';

?>
