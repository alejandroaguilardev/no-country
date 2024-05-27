<?php

namespace App\Domain\Criteria;

use App\Domain\Errors\ErrorDomain;

final class GlobalFields
{
    public array $fields = [];

    public function __construct(array $fields = [])
    {
        $this->fields = [];
        $this->format($fields);
    }

    private function format(array $fields): void
    {
        foreach ($fields as $field) {
            $this->enSecure($field);
            $this->fields[] = $field;
        }
    }

    public function toArray(): array
    {
        return $this->fields;
    }

    private function enSecure($field)
    {
        if (!is_string($field)) {
            throw new ErrorDomain('El campo debe ser un string en globalfields =' . $field, 400);
        }
    }
}
