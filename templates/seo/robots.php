<?php
echo "User-agent: *\n";

if (!$params['indexing_allowed']) {
    echo "Disallow: /\n";
    return;
}

echo "Allow: /\n";
echo "Disallow: /dashboard\n";
echo "Disallow: /auth/\n";
echo "Disallow: /subscribe\n";
echo "Disallow: /confirm-subscription\n";
echo "Disallow: /unsubscribe\n";
echo "\nSitemap: " . $params['sitemap_url'] . "\n";
