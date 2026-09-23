<?php
use App\Content\HomepagePostTypes;

$content = $params['content'] ?? [];

$homepagePosts = $content['homepagePosts'] ?? [];
$homepageFeeds = $content['homepageFeeds'] ?? [];
?>

<?php foreach ($homepagePosts as $post): ?>
    <?php
        $type = (string) ($post->type ?? HomepagePostTypes::SIMPLE_TEXT);
        $partial = HomepagePostTypes::partial($type);
        $feedPosts = $homepageFeeds[$post->id] ?? [];

        if ($partial === null) {
            $type = HomepagePostTypes::SIMPLE_TEXT;
            $partial = HomepagePostTypes::partial($type);
        }

        $partialPath = 'templates/pages/homepage_posts/' . $partial;
        $payload = json_decode((string) ($post->payload ?? ''), true) ?: [];
        $block = $payload;
    ?>

    <?php require $partialPath; ?>
<?php endforeach ?>

<script src="/public/js/scroll.js"></script>
