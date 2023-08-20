<?php

namespace Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationUnitTest extends TestCase
{
    public function testNotEmpty()
    {
        try {
            $value = '';
            DomainValidation::notEmpty($value);

            $this->assertTrue(false);
        } catch (Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }

    public function testNotEmptyCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notEmpty($value, 'Custom message error');

            $this->assertTrue(false);
        } catch (Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable, 'Custom message error');
        }
    }

    public function testStrMaxLength()
    {
        try {
            $value = 'this is a test';
            DomainValidation::strMaxLength($value, 5, 'Custom Message');

            $this->assertTrue(false);
        } catch (Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable, 'Custom message error');
        }
    }

    public function testStrMinLength()
    {
        try {
            DomainValidation::strMinLength('test', 5, 'Custom Message');

            $this->assertTrue(false);
        } catch (Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable, 'Custom message error');
        }
    }

    public function testStrCanEmptyAndMaxLength()
    {
        try {
            DomainValidation::strCanEmptyAndMaxLength('test', 3, 'Custom Message');

            $this->assertTrue(false);
        } catch (Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable, 'Custom message error');
        }
    }
}