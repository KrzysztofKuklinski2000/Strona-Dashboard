<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($params['urls'] as $url): ?>
    <url><loc><?= htmlspecialchars($url, ENT_XML1 | ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></loc></url>
<?php endforeach ?>
</urlset>
