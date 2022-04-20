<?php

namespace App\Models;

use Timber\Pagination as TimberPagination;

class Pagination extends TimberPagination implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return array(
            'currentPage' => $this->current,
            'totalPages' => $this->total,
        );
    }
}
