<?php

namespace App\Traits;

trait CanEscapeLike
{
    /**
     * Escape special characters for LIKE queries.
     *
     * @param string $value
     * @return string
     */
    protected function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $value);
    }
}
