<?php

namespace App\Exceptions;


class NotFoundException extends ApiException
{
    public function __construct(string $message = "")
    {
        return parent::__construct($message,'NOT FOUND', 404);
    }
}
