<?php
$shareQuery = "SELECT * FROM profile JOIN posts ON posts.user_ID = profile.user_ID WHERE posts.id = ? AND posts.user_ID = ?;";
if ($shareStmt = $conn->prepare($shareQuery)):
  $shareStmt->bind_param('ii', $row['share_ref'], $row['share_user_ref']);
  $shareStmt->execute();
  $shareResult = $shareStmt->get_result();
  while ($shareRow = $shareResult->fetch_array()):
?>
<div class="post">
  <p><?php echo $row['first_name'] . " " . $row['last_name']; ?> shared this on <?php echo $row['post_time']; ?>:</p>
    <div class="header-post">
        <div class="image">
            <img src="<?php echo $shareRow['profile_picture'] ?>" alt="" width="100" height="100">
        </div>
        <div class="name-time">
            <p><?php echo $shareRow["first_name"] . " " . $shareRow["last_name"]?></p>
             <span> posted on <?php echo $shareRow["post_time"]?></span>
        </div>
    </div>
    <div>
        <h2><?php echo $shareRow["name"]?></h2>
        <p><?php echo $shareRow["content"]?></p>
        <?php if ($row['user_ID'] != $_SESSION['id']): ?>
        <a href='../includes/share_post.php?postId=<?php echo $row['id']?>'>Share</a>
        <?php endif; ?>
    </div>
    <?php $id = $shareRow["id"];?>
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
          <p>Reposts: <?php echo $row['reposts'] ?></p>
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
<?php
endwhile;
endif;
?>
