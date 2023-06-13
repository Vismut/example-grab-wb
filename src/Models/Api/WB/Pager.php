<?php

namespace Src\Models\Api\WB;

class Pager
{
    public array $pages = [];

    public function addPage(int $value, string $url): void
    {
        if (!isset($this->pages[$value])) {
            $this->pages[$value] = $url;
        }
    }

    public function calcPages(array $pagingInfo, string $baseUrl): Pager
    {
        $totalPages = intdiv($pagingInfo['totalItems'], $pagingInfo['currentPageSize']);

        if ($totalPages > 100) {
            $totalPages = 100;
        }

        while ($totalPages > 1) {
            $this->addPage($totalPages, $baseUrl . '?page=' . $totalPages);
            $totalPages--;
        }

        $this->addPage($totalPages, $baseUrl);

        return $this;
    }
}