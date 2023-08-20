<?php

namespace Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
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

        $this->assertNotEmpty($category->createdAt());
        $this->assertIsString($category->id());
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
        $uuid = Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'New Category',
            description: 'New desc',
            isActive: true,
            createdAt: '2023-12-20 22:10:11'
        );

        $category->update(
            name: $name,
            description: $description
        );

        $this->assertEquals($uuid, $category->id());
        $this->assertEquals($name, $category->name);

        if (!empty($description)) {
            $this->assertEquals($description, $category->description);
        }
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'N',
                description: 'New desc',
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Category(
                name: 'Name test',
                description: random_bytes(99999),
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