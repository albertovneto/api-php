<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    public static function notEmpty(?string $value, ?string $exceptMessage = null)
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptMessage ?? "Should not be empty or null");
        }
    }

    public static function strMaxLength(string $value, int $maxLength = 255, ?string $exceptMessage = null)
    {
        if (strlen($value) > $maxLength) {
            throw new EntityValidationException(
                $exceptMessage ?? "The value must not be greater than $maxLength characters"
            );
        }
    }

    public static function strMinLength(string $value, int $minLength = 2, ?string $exceptMessage = null)
    {
        if (strlen($value) < $minLength) {
            throw new EntityValidationException(
                $exceptMessage ?? "The value must not be less than $minLength characters"
            );
        }
    }

    public static function strCanEmptyAndMaxLength(?string $value, int $maxLength = 255, ?string $exceptMessage = null)
    {
        if (
            empty($value) === false
            && strlen($value) > $maxLength
        ) {
            throw new EntityValidationException(
                $exceptMessage ?? "The value must not be greater than $maxLength characters"
            );
        }
    }

}