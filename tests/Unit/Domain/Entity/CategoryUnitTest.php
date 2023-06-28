<?php

namespace Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Throwable;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'New Category',
            description: 'New desc',
            isActive: true
        );

        $this->assertEquals('New Category', $category->name);
        $this->assertEquals('New desc', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(
            name: 'New Category',
            isActive: false
        );

        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDisabled()
    {
        $category = new Category(
            name: 'New Category',
            isActive: true
        );

        $this->assertTrue($category->isActive);
        $category->disable();
        $this->assertFalse($category->isActive);
    }

    /**
     * @dataProvider updateProvider
     */
    public function testUpdate(
        string $name,
        ?string $description = null
    )
    {
        $uuid = 'uuid_fake';
        $category = new Category(
            id: $uuid,
            name: 'New Category',
            description: 'New desc',
            isActive: true
        );

        $category->update(
            name: $name,
            description: $description
        );

        $this->assertEquals($name, $category->name);

        if (!empty($description)) {
            $this->assertEquals($description, $category->description);
        }
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'Ne',
                description: 'New desc',
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public static function updateProvider(): array
    {
        return [
            'update without description' => ['update name'],
            'update with description' => ['update name', 'update desc'],
        ];
    }
}