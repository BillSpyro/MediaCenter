
<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
include_once "../includes/create_notification_inc.php";

?>

<!-- welcome page, login, and register link -->
<section class="home">
<h1>Hi Welcome to our site!</h1>
<?php if (!isset($_SESSION['id'])):?>
   <div class="home-log">
       <p>Have an account? Log in.</p>
        <li><a class="home-login" href="../auth/login.php">Log In</a></li>
        <p>Don't have an account? register.</p>
        <li><a class="home-register" href="../auth/register.php">Register</a></li>
    <?php else:
        $user_id = $_SESSION['id'];
        ?>
    <?php include_once "../posts/create_post.php"; ?>

    <!-- get all posts in post time order  -->
    <?php
    $query = "SELECT * FROM profile, posts WHERE posts.user_ID = profile.user_ID ORDER BY post_time DESC";
    $result = $conn->query($query);
    ?>
    <?php while ($row = $result->fetch_array()):  ?>

    <div class="posts">
      <?php if (is_null($row['share_ref'])): ?>
        <div class="post">
            <div class="header-post">
                <div class="image">
                    <img src="<?php echo $row['profile_picture'] ?>" alt="" width="100" height="100">
                </div>
                <div class="name-time">
                    <p><?php echo $row["first_name"] . " " . $row["last_name"]?></p>
                     <span> posted on <?php echo $row["post_time"]?></span>
                </div>
            </div>
            <div>
                <h2><?php echo $row["name"]?></h2>
                <p><?php echo $row["content"]?></p>
                <?php if ($row['user_ID'] != $_SESSION['id']): ?>
                <a href='../includes/share_post.php?postId=<?php echo $row['id']?>'>Share</a>
                <?php endif; ?>
                <?php if (is_null($row['video_link'])): ?>
              <?php else: ?>
                <img class="post-image" src=<?php echo $row['video_link']; ?>>
              <?php endif; ?>
            </div>
            <?php $id = $row["id"];?>
            <hr>
                <div class="likes-button">
                    <form action="index.php" method="post">
                        <input class="id" type="text" name="postId" value="<?php echo $id?>" hidden>
                        <button class="submit-button" type="submit" name="Like" ><img class="like-image" src="https://img.icons8.com/flat-round/64/000000/good-quality--v1.png"/></button>
                    </form>


                </div>

                <div>
<!-- check if the user like the post  -->

                <div>
                  <p>Reposts: <?php echo $row['reposts']; ?></p>

<div>
        <?php
            $sql_isliked = "SELECT likes  FROM likes  WHERE post_ID = '$id' and user_id=$user_id;";
            $isliked_ressult= $conn->query($sql_isliked);
            if ($isliked_ressult->num_rows > 0) {
                while($row = $isliked_ressult->fetch_assoc()) {
                    $isLiked = $row['likes'];
                    if ($isLiked == 1) {
                        echo "you liked this post";
                    }else {
                        echo "you didn't like the post";
                    }
                    }
            }else {
                    echo "you didn't like the post";
                }
                ?>



</div>
    <!-- get the total amount of comments in each pages -->
            <div>
                <?php
                $sql_count_comments = "SELECT COUNT(content) AS NumberOfComments FROM comments WHERE post_ID = '$id';";
                $TotalComment_ressult= $conn->query($sql_count_comments);
                if ($TotalComment_ressult->num_rows > 0) {
                    while($row = $TotalComment_ressult->fetch_assoc()) {
                        $NumberOfComments = $row['NumberOfComments'];

                        }
                }else {
                    echo "0 results";
                }
                ?>

                </div>

                <?php
// get the total amount of likes in each pages
                $sql_rate_count = "SELECT COUNT(likes) AS NumberOfLikes FROM likes WHERE post_ID = '$id';";
                $result1 = $conn->query($sql_rate_count);
                if ($result1->num_rows > 0) {
                    while($row = $result1->fetch_assoc()) {
                        $NumberOfLikes = $row['NumberOfLikes'];

                        }
                }else {
                    echo "0 results";
                }
                ?>
                </div>
                <!-- show total comments and likes  -->
                <div class="total_likes_comments">
                    <div><p class="show-comments"><?php echo $NumberOfComments;?> Comments</p></div>
                    <div><p class="show-likes"><?php echo $NumberOfLikes;?> Likes</p></div>
                </div>
            </div>
            <hr>
            <section>
                <form class="comment-form" action="index.php" method="POST">
                    <input type="text" name="postId" value="<?php echo $id;?>" hidden>
                    <input type='text' name='comment' placeholder="type comment" required>
                    <input type='submit' name="submitcomment">
                </form>
      </section>
      <?php else: ?>
        <?php include "../includes/share_post_display.php"; ?>
      <?php endif; ?>

      <div>

        <div>
        <?php
        $query_comments = "SELECT profile.*, comments.*, users.* FROM users, profile, comments WHERE users.id = profile.user_ID and users.id=comments.user_ID and comments.post_ID = '$id';";
        $result2 = $conn->query($query_comments);
?>

<!-- get the comments -->
<div class="comments">
<p>all comments</p>
<?php while ($row1 = $result2->fetch_array()):  ?>
        <div class="comment">
            <div class="header-comment">
            <div class="image">
                    <img src="<?php echo $row1['profile_picture'] ?>" alt="" width="30" height="30">
                </div>
                <div class="name-time">
                    <p><?php echo $row1["first_name"] . " " . $row1["last_name"]?>  <span>commented on <?php echo $row1["posted_date"]?></span></p>
                </div>
            </div>
                <div class="comment-one">
                <p class="single-comment"><?php echo $row1["content"]?></p>
            </div>
        </div>
    <?php endwhile ?>

        </div>
      </div>
    </div>
  </div>
 </div>
<?php endwhile ?>
<?php endif ?>

<!-- Insert new  comment -->
    <?php
        if(isset($_POST["submitcomment"])) {

            $postId = $_POST['postId'];
            $comment = $_POST['comment'];
            $dateTime = date('Y-m-d H:i:s');
            $query = "INSERT INTO comments (user_ID, post_ID, posted_date, content) VALUES (?, ?, ?, ?);";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param('iiss', $user_id, $postId, $dateTime, $comment);
                $stmt->execute();
                echo "success comment";
                $stmt->close();
                }else {
                    echo "somethimg went wrong";
                }

                //Getting ID of the comment that was made
                $query = "SELECT * FROM comments WHERE user_ID = ? and post_ID = ? and content = ? and posted_date = ?";
                if ($stmt = $conn->prepare($query)) {

                  $stmt->bind_param("iiss", $user_id, $postId, $comment, $dateTime);

                  $stmt->execute();

                  $result = $stmt->get_result();

                  while ($row = $result->fetch_array()) {
                    $commentID = $row['id'];
                  }
                }

                //Getting ID of the post owner
                $query = "SELECT * FROM posts WHERE id = ? ";
                if ($stmt = $conn->prepare($query)) {

                  $stmt->bind_param("i", $postId);

                  $stmt->execute();

                  $result = $stmt->get_result();

                  while ($row = $result->fetch_array()) {
                    $ownerID = $row['user_ID'];
                  }
                }

                $conn->close();

                createNotification('Comment', $commentID, $ownerID, $postId);
            }
        ?>

<!-- insert new like  -->
    <?php
    if(isset($_POST["Like"])) {
        $post_id = $_POST["postId"];
        $sql_rate = "SELECT likes.likes FROM users, likes, posts WHERE likes.post_ID = posts.id and likes.user_ID  = users.id and users.id = '$user_id' and posts.id = '$post_id';";
        $result = $conn->query($sql_rate);
        if (!empty($result) && $result->num_rows > 0) {
            $query_delete_like = "DELETE FROM likes WHERE post_ID = ? and user_ID = ?;";
            if ($stmt = $conn->prepare($query_delete_like)) {
                $stmt->bind_param('ii', $post_id, $user_id);
                $stmt->execute();
                $unliked = "you didn't like the post yet";
                $stmt->close();
                exit();
  }
        }else {
            $rate_value = 1;
            $query = "INSERT INTO likes (user_ID, post_ID, profile_ID, likes) VALUES (?, ?, ?, ?);";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iiii", $user_id, $post_id, $user_id, $rate_value);
                $stmt->execute();
                $liked = "you liked the post";
                echo $liked;
                $stmt->close();
                }
            }

            //Getting ID of the post owner
            $query = "SELECT * FROM posts WHERE id = ?";
            if ($stmt = $conn->prepare($query)) {

              $stmt->bind_param("i", $post_id);

              $stmt->execute();

              $result = $stmt->get_result();

              while ($row = $result->fetch_array()) {
                $ownerID = $row['user_ID'];
              }
            }


            createNotification('Like', $user_id, $ownerID, $post_id);

            $conn->close();
    }
?>
<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function() {
        $(".submit").click(function() {
        var postid = $(".id").val();
        alert("clicke on " + postid)
        $.ajax({
        type: "post",
        async: false,
        data: {
            "postid": postid
        },
        url: "index.php",
        success: function() {
            }
        });
    });
});
</script>
-->

</div>
</section>

<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
