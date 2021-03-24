
<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

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



    <?php
    $query = "SELECT * FROM profile, posts WHERE posts.user_ID = profile.user_ID ORDER BY post_time DESC";
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
            </div>
            <div>
                <h2><?php echo $row["name"]?></h2>
                <p><?php echo $row["content"]?></p>
                <?php if ($row['user_ID'] != $_SESSION['id']): ?>
                <a href='../includes/share_post.php?postId=<?php echo $row['id']?>'>Share</a>
                <?php endif; ?>
            </div>
            <?php $id = $row["id"];?>
            <div>
            <hr>
                <div>
                    <form action="index.php" method="post">
                        <input class="id" type="text" name="postId" value="<?php echo $id?>" hidden>
                        <input class="submit" type="submit" name="Like" value="Like">
                    </form>
                </div>

                <div>

                <div>
                </div>
                <?php

                $sql_rate_count = "SELECT COUNT(likes) AS NumberOfLikes FROM likes WHERE post_ID = '$id';";
                $result1 = $conn->query($sql_rate_count);
                if ($result1->num_rows > 0) {
                    while($row = $result1->fetch_assoc()) {
                        $numberOfLikes = $row['NumberOfLikes'];
                         echo "<? id='likes'>total likes  . $numberOfLikes</?>";
                        }
                }else {
                    echo "0 results";
                }
                ?>
                </div>
            </div>
            <hr>
            <section>
                <form class="comment-form" action="../includes/create_post_comment.php" method="POST">
                    <input type="text" name="postId" value="<?php echo $id;?>" hidden>
                    <input type='text' name='comment' value="type comment">
                    <input type='submit'>
                </form>
      </section>
        </div>


    </div>

    <?php endwhile ?>


    <?php endif ?>
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
                $stmt->close();
                exit();
  }
        }else {
            $rate_value = 1;
            $query = "INSERT INTO likes (user_ID, post_ID, profile_ID, likes) VALUES (?, ?, ?, ?);";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iiii", $user_id, $post_id, $user_id, $rate_value);
                $stmt->execute();
                echo "you liked the post successfully";
                $stmt->close();
                }
            }
            $conn->close();
    }
?>
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

</div>
</section>
<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
