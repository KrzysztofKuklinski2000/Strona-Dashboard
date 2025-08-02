<?php 
	$params = $params['content'];
    $firstPost = $params[2];
    $importantPosts = $params[1];
    $params = $params[0];
	$counter = 0;
?>
<div class="respons-container arrows-container">
    <div class="important-info">
        <?php foreach($importantPosts ?? [] as $post): ?>
            <?php if($post['status']): ?>
                <div class="info-box">
                    <div class="info-icon <?php echo $post['important'] === 0 ? 'info-neg' : 'info-que' ?>">
                        <i class="fa-solid <?php echo $post['important'] === 0 ? 'fa-exclamation' : 'fa-question' ?> "></i>
                    </div>
                    <h2 class="info-title"> <?php echo $post['title'] ?> </h2>
                    <p class="info-description"> <?php echo $post['description'] ?> </p>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
    <div class="info-arrows">
        <div class="left-arrow"><i class="fa-solid fa-angle-left"></i></div>
        <div class="right-arrow"><i class="fa-solid fa-angle-right"></i></div>
    </div>
</div>
<div class="padding-top">
    <?php if($firstPost['status']): ?>
        <div class="post-free">
            <div class="post">
                <div class="left-side-post">
                    <?php 
                        $text = $firstPost['title']; 
                        require('templates/components/post_header.php'); 
                    ?>
                </div>
                <div class="post-content flex-item-center">
                    <span>zajęcia za darmo</span>
                    <p><?php echo $firstPost['description']; ?></p><br/>
                    <a class="text-uppercase" href="?view=zapisy">Zapisz się</a>
                </div>
            </div>
        </div>
    <?php endif ?>
        <?php foreach($params ?? [] as  $content): ?>
            <?php if($content['status']): ?>
                <?php $class = $content['id'] % 2 === 0 ? "dark-post" : 'light-post'  ?>
                <div class="post">
                    <?php
                        $text = $content['title']; 
                        require('templates/components/post_header.php');
                    ?>
                    <div class="post-content flex-item-center <?= $class ?>">
                        <p> <?php echo $content['description']; ?></p>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <script src="public/js/scroll.js"></script>