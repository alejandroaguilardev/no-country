<?php

declare (strict_types = 1);

namespace App\Domain\Criteria;

final class FilterOperator
{
    public const EQUAL = '=';
    public const NOT_EQUAL = '!=';
    public const GT = '>';
    public const LT = '<';
    public const CONTAINS = 'CONTAINS';
    public const NOT_CONTAINS = 'NOT_CONTAINS';

    public static function isContaining(string $operator): bool
    {
        return in_array($operator, [self::CONTAINS, self::NOT_CONTAINS], true);
    }

}
