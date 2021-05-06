
<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
include_once "../includes/create_notification_inc.php";
include_once "../posts/post_like_inc.php";

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
                    <?php // delete and edit post button if that user owns the post
                    if ($row['user_ID'] == $_SESSION['id']) {
                        printf('<a class="btn" href="../posts/edit_post.php?postid=%s">Edit Post</a>', $row['id']);
                        printf('<a class="btn" href="../includes/delete_post.php?postId=%s">Delete Post</a>', $row['id']);
                }
            ?>
                </div>
                <div>
                    <h2 id=<?php echo $row['id'];?>><?php echo $row["name"]?></h2>
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
                        <!-- basic html form to like the post -->
                        <div class="likes-button">
                            <form action="../posts/post_like_inc.php" method="post">
                                <input class="id" type="text" name="postId" value="<?php echo $id?>" hidden>
                                <button class="submit-button" type="submit" name="Like" ><img class="like-image" src="https://img.icons8.com/flat-round/64/000000/good-quality--v1.png"/></button>
                            </form>
                        </div>
                        <div>
                            <div>
                            <!-- share the post -->
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
                            <!-- basic html form to create a post comment -->
                            <form class="comment-form" action="../includes/create_post_comment.php" method="POST">
                                <input type="text" name="postId" value="<?php echo $id;?>" hidden>
                                <input type='text' name='comment' placeholder="type comment" required>
                                <input type='submit' name="submitcomment">
                            </form>
                        </section>
                        <?php else: ?>
                            <?php include "../includes/share_post_display.php"; ?>
                        <?php endif; ?>
                            <?php

                                $query_comments = "SELECT profile.*, comments.* FROM profile, comments WHERE comments.user_ID = profile.user_ID  and comments.post_ID = '$id' and comments.comment_ID is null;";
                                $result2 = $conn->query($query_comments);
                            ?>
                            <div class="comments">
                                <p>all comments</p>
                                <?php while ($row1 = $result2->fetch_array()):  ?>
                                <?php 

                                    $post_id = $row1['post_ID'];
                                    $comment_ID = $row1["id"];    
                                ?>
                                <div class="comment">
                                <?php 
                                    if ($row1['user_ID'] == $_SESSION['id']) {
                                        // row1[14] is the comment's ID
                                        printf(<<<EOT
                                        <a class="comment-btn" href="../posts/edit_comment.php?commentId=%s">Edit Comment</a>
                                        <a class="comment-btn" href="../includes/delete_comment.php?commentId=%s&postId=%s">Delete Comment</a>
                                        EOT, $row1[14], $row1[14], $row1['post_ID']);
                                    }
                                    ?>
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
                                        <!-- get nusted comment   -->
                                        <div>
                                            <?php
                                                $query_nusted_comments = "SELECT profile.*, comments.* FROM profile, comments WHERE comments.user_ID = profile.user_ID and comments.post_ID = '$post_id' and comments.comment_ID = '$comment_ID';";
                                                $result3 = $conn->query($query_nusted_comments);
                                            ?>
                                            <div class="nested_comment">
                                                <?php while ($row3 = $result3->fetch_array()):  ?>
                                                <div class="nusted_comment">
                                                    <div class="header-comment">   
                                                        <div class="image">
                                                            <img src="<?php echo $row3['profile_picture'] ?>" alt="" width="30" height="30">
                                                        </div>
                                                        <div class="name-time">
                                                            <p><?php echo $row3["first_name"] . " " . $row3["last_name"]?>  <span>replied on <?php echo $row3["posted_date"]?></span></p>
                                                        </div>

                                                        <!-- update and delete nested comments -->
                                                        <?php if ($_SESSION['id'] == $row3["user_ID"]):?>
                                                        <div class="edit-delete">
                                                        <div class="edit">
                                                        
                                                        <a class="edit-profile--link" href="../posts/post_nested_comment/edit_nested_comment.php?ID=<?php echo $row3["id"] ?>&commentID=<?php echo $row3["comment_ID"] ?>&postID=<?php echo $row3["post_ID"] ?>&content=<?php echo $row3["content"]?>"><img class="edit_icon" src="https://img.icons8.com/android/24/000000/edit.png"/></a> 
                                                        </div>
                                                        <div class="delete">
                                                        <form action="../posts/post_nested_comment/delete_nested_comment.php" method="post">
                                                            <input type="text" name="post_id" value="<?php echo $row3["post_ID"]?>" hidden>
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
                                            
                                        <!-- basic form to create a nested comment  -->
                                        <div>
                                            <form class="nusted_comment-form" action="../includes/post_nested_comment_inc.php" method="POST">
                                                <input type="text" name="postId" value="<?php echo $post_id;?>" hidden>
                                                <input type="text" name="post_comment_ID" value="<?php echo $comment_ID;?>" hidden>
                                                <input type='text' name='comment' placeholder="reply comment ... " required>
                                                <input type='submit' name="submitcomment">
                                            </form>
                                        </div>
                                </div>
                            <?php endwhile ?>
                        </div>    
                    </div>
                </div>
            <?php endwhile ?>
        <?php endif ?>
    </div>
</section>
<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
