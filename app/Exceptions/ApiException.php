<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    private string $errorCode;
    private int $statusCode;
    private string $data;

    public function __construct(string $message = "",string $errorCode='ERROR', int $statusCode=500, string $data=''){
        parent::__construct($message,$statusCode);
        $this->errorCode= $errorCode;
        $this->statusCode=$statusCode;
        $this->data = $data;
    }

    /**
     * Get the value of errorCode
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Set the value of errorCode
     *
     * @return  self
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Get the value of statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the value of statusCode
     *
     * @return  self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
