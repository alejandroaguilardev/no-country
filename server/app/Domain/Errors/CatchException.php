<?php

namespace App\Domain\Errors;

class CatchException
{
    private int $code = 500;
    private string $defaultMessage = "No se ha capturado esta excepción, comunicarse con el equipo de backend";

    public function __construct(
        private $value,
    ) {}

    public function getCode(): int
    {
        if ($this->value instanceof ErrorDomain && method_exists($this->value, 'getCode')) {
            return $this->value->getCode();
        }
        return $this->code;
    }

    public function getMessage(): array
    {
        if ($this->value instanceof ErrorDomain && method_exists($this->value, 'getCode')) {
            return ["message" => $this->value->getMessage()];
        }
        return ["message" => $this->defaultMessage, "error" => $this->value->getMessage()];
    }
}
