<div class="respons-container arrows-container">
    <div class="important-info">
        <?php foreach($params['content'][1] ?? [] as $post): ?>
            <?php if($post['status']): ?>
                <div class="info-box">
                    <div class="info-icon <?= $post['important'] === 0 ? 'info-neg' : 'info-que' ?>">
                        <i class="fa-solid <?= $post['important'] === 0 ? 'fa-exclamation' : 'fa-question' ?> "></i>
                    </div>
                    <h2 class="info-title"> <?= $post['title'] ?> </h2>
                    <p class="info-description"> <?= $post['description'] ?> </p>
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
    <?php if($params['content'][2]['status']): ?>
        <div class="post-free">
            <div class="post">
                <div class="left-side-post">
                    <?php 
                        $text = $params['content'][2]['title']; 
                        require('templates/components/post_header.php'); 
                    ?>
                </div>
                <div class="post-content flex-item-center">
                    <span>zajęcia za darmo</span>
                    <p><?= $params['content'][2]['description']; ?></p><br/>
                    <a class="text-uppercase" href="?view=zapisy">Zapisz się</a>
                </div>
            </div>
        </div>
    <?php endif ?>
        <?php foreach($params['content'][0] ?? [] as  $content): ?>
            <?php if($content['status']): ?>
                <?php $class = $content['id'] % 2 === 0 ? "dark-post" : 'light-post'  ?>
                <div class="post">
                    <?php
                        $text = $content['title']; 
                        require('templates/components/post_header.php');
                    ?>
                    <div class="post-content flex-item-center <?= $class ?>">
                        <p> <?= $content['description']; ?></p>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <script src="public/js/scroll.js"></script>