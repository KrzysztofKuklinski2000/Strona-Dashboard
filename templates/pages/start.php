<?php 
	$params = $params['content'];
    $importantPosts = $params[1];
    $params = $params[0];
	$counter = 0;
?>
<div class="respons-container arrows-container">
    <div class="important-info">
        <?php foreach($importantPosts ?? [] as $post): ?>
            <?php if($post['status']): ?>
                <div class="info-box">
                    <div class="info-icon <?php echo $post['important'] == 1 ? 'info-neg' : 'info-que' ?>">
                        <i class="fa-solid <?php echo $post['important'] == 1 ? 'fa-exclamation' : 'fa-question' ?> "></i>
                    </div>
                    <h2 class="info-title"> <?php echo $post['title'] ?> </h2>
                    <p class="info-description"> <?php echo $post['description'] ?> </p>
                    <strong class="info-date"> <?php echo $post['updated'] ?> </strong>
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
    <?php if($params[0]['status']): ?>
        <div class="post-free">
            <div class="post">
                <div class="left-side-post">
                    <?php 
                        $text = $params[0]['title']; 
                        require('templates/components/post_header.php'); 
                    ?>
                </div>
                <div class="post-content flex-item-center">
                    <span>zajęcia za darmo</span>
                    <p><?php echo $params[0]['description']; ?></p><br/>
                    <a class="text-uppercase" href="?view=zapisy">Zapisz się</a>
                </div>
            </div>
        </div>
    <?php endif ?>
        <?php foreach($params ?? [] as $content): ?>
            <?php if($content['status']): ?>
            <div class="post">
                <?php
                	if($counter++ == 0) continue;
                    $text = $content['title']; 
                    require('templates/components/post_header.php');
                ?>
                <div class="post-content flex-item-center">
                   <p> <?php echo $content['description']; ?></p>
                </div>
            </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <script src="public/js/scroll.js"></script>