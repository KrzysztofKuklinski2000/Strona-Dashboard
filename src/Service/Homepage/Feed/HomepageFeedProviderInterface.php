<?php
declare(strict_types=1);

namespace App\Service\Homepage\Feed;

interface HomepageFeedProviderInterface
{
    public function module(): string;
    public function getItems(int $limit): array;
}