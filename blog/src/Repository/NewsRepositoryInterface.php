<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;

interface NewsRepositoryInterface
{
    public function getFilteredNews(int $page, int $pageSize, ?string $date, ?string $tags): array;
}
