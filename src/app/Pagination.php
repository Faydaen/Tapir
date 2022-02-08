<?php


namespace Tapir;


class Pagination
{
    protected const PER_PAGE = 10;

    public int $page;

    public int $limit;

    public int $offset;

    public function __construct($page = 1)
    {
        $this->page = $page;
        $this->limit = self::PER_PAGE;
        $this->offset = self::PER_PAGE * ($page-1);
    }

    public function getTotalPages($countRows) : int {
        return ceil($countRows / self::PER_PAGE);
    }
}
