<?php

use App\Content\HomepagePostTypes;

$post = $data;
$type = (string) ($post->type ?? HomepagePostTypes::SIMPLE_TEXT);

if (!HomepagePostTypes::isAllowed($type)) {
    $type = HomepagePostTypes::SIMPLE_TEXT;
}

$partial = HomepagePostTypes::partial($type)
    ?? HomepagePostTypes::partial(HomepagePostTypes::SIMPLE_TEXT);
$block = json_decode((string) ($post->payload ?? ''), true);
$block = is_array($block) ? $block : [];
$feedPosts = is_array($previewFeedPosts ?? null) ? $previewFeedPosts : [];

ob_start();

if ($partial !== null) {
    require 'templates/pages/homepage_posts/' . $partial;
}

$previewHtml = ob_get_clean();
$previewTitle = 'Podgląd sekcji na stronie głównej';

require 'templates/dashboard/_partials/_public_post_preview.php';
