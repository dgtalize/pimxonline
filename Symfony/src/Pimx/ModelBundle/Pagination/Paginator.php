<?php

namespace Pimx\ModelBundle\Pagination;


class Paginator {

    private $pageSize;
    private $currentPage;

    public function __construct($pageSize, $currentPage) {
        $this->pageSize = $pageSize;
        $this->currentPage = $currentPage;
    }

    public function getOffset() {
        return $this->pageSize * ($this->currentPage - 1);
    }

    public function getPageSize() {
        return $this->pageSize;
    }

    public function setPageSize($value) {
        $this->pageSize = $value;
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function setCurrentPage($value) {
        $this->currentPage = $value;
    }

}
