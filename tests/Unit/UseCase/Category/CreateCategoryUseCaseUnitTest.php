<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\{
    CategoryCreateInputDto,
    CategoryCreateOutputDto
};
use PHPUnit\Framework\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    private $mockRepository;
    private $mockEntity;

    public function testCreateNewCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'New Category';
        $categoryDescription = 'New description';

        $this->mockEntity = Mockery::mock(
            Category::class,
            [$uuid, $categoryName, $categoryDescription]
        );
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('insert')
            ->andReturn($this->mockEntity);

        $mockCategoryCreateInputDto = Mockery::mock(CategoryCreateInputDto::class, [
            $categoryName,
            $categoryDescription
        ]);

        $categoryUseCase = new CreateCategoryUseCase($this->mockRepository);

        $responseUseCase = $categoryUseCase->execute($mockCategoryCreateInputDto);

        $this->assertInstanceOf(CategoryCreateOutputDto::class, $responseUseCase);
        $this->assertEquals($categoryName, $responseUseCase->name);
        $this->assertEquals($categoryDescription, $responseUseCase->description);

        Mockery::close();
    }
}