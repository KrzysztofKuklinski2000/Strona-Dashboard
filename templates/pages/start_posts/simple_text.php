<?php
$class = ($post->id ?? 0) % 2 === 0 ? 'dark-post' : 'light-post';
?>

<div class="post">
    <?php
        $text = $post->title ?? '';
        require('templates/components/post_header.php');
    ?>

    <div class="post-content flex-item-center <?= e($class) ?>">
        <p><?= e_br($post->description ?? '') ?></p>
    </div>
</div>
