<?php

    $db = mysqli_connect('pirogue-database', 'website', 'app-test-website-password', 'website');
    $sql_results = mysqli_query($db, 'select * from users');

?>
<?php if ( $sql_results ): ?>
    <?php while ( $data = mysqli_fetch_assoc($sql_results)): ?>
        <div class="user">
            <span class="user-name"><?php echo $data['name']; ?></span>
            <span class="user-email"><?php echo $data['email']; ?></span>
            <span class="user-actions">
                <a href="edit.php?id=<?php echo $data['id']; ?>" class="" title="">
                    <span class="">edit</span>
                </a>
            </span>    
        </div>
    <?php endwhile; ?>
    <?php mysqli_free_result($sql_results); ?>
<?php endif; ?>
<pre><?php var_dump($_GET); ?></pre>
<pre><?php print_r(__FILE__); ?></pre>
