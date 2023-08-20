<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use PHPUnit\Framework\TestCase;
use Mockery;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    private $mockRepository;
    private $mockEntity;

    public function testCreateNewCategory()
    {
        $categoryAttributes = ['1', 'New Category', 'New desc'];
        $this->mockEntity = Mockery::mock(Category::class, $categoryAttributes);

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class)
            ->shouldReceive('insert')
            ->andReturn($this->mockEntity);

        $categoryUseCase = new CreateCategoryUseCase($this->mockRepository);

        $categoryUseCase->execute();
    }
}