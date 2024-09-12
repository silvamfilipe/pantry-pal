<?php
/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\App\Infrastructure;

use App\Domain\Recipe;
use App\Infrastructure\JsonRecipeRepository;
use PHPUnit\Framework\TestCase;
use Slick\Di\Exception\NotFoundException;

class JsonRecipeRepositoryTest extends TestCase
{

    private JsonRecipeRepository $repo;

    protected function setUp(): void
    {
        $this->repo = new JsonRecipeRepository();
    }

    public function testIsInitializable(): void
    {
        $this->assertInstanceOf(JsonRecipeRepository::class, $this->repo);
    }

    public function testAll(): void
    {
        $this->assertCount(15, $this->repo->all());
    }

    public function testWithRecipeId(): void
    {
        $recipeId = md5("Greek Salad");
        $recipe = $this->repo->withRecipeId($recipeId);
        $this->assertInstanceOf(Recipe::class, $recipe);
    }

    public function testRecipeNotFound(): void
    {
        $recipeId = md5("Greek Salads");
        $this->expectException(NotFoundException::class);
        $recipe = $this->repo->withRecipeId($recipeId);
        $this->assertNull($recipe);
    }

    public function testSearchBy(): void
    {
        $recipes = $this->repo->searchBy("eggs");
        $this->assertCount(3, $recipes);
    }
}
