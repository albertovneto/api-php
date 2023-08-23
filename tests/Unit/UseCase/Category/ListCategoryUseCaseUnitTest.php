<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\{
    CategoryInputDto,
    CategoryOutputDto
};
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Mockery;
use stdClass;

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'Test Category';

        $mockEntity = Mockery::mock(
            Category::class,
            [$id, $categoryName]
        );
        $mockEntity->shouldReceive('id')->andReturn($id);

        $mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($id)
            ->andReturn($mockEntity);

        $mockCategoryInputDto = Mockery::mock(CategoryInputDto::class, [
            $id,
        ]);

        $useCase = new ListCategoryUseCase($mockRepository);
        $response = $useCase->execute($mockCategoryInputDto);

        $this->assertInstanceOf(CategoryOutputDto::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}