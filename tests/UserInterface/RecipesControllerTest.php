<?php
/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\App\UserInterface;

use App\Domain\Recipe;
use App\Domain\RecipeRepository;
use App\UserInterface\RecipesController;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Template\TemplateEngineInterface;

class RecipesControllerTest extends TestCase
{
    private TemplateEngineInterface&MockObject $engine;
    private RecipeRepository&MockObject $recipeRepository;

    private ServerRequestInterface&MockObject $request;

    private RecipesController $controller;
    function setUp(): void
    {
        $this->engine = $this->createMock(TemplateEngineInterface::class);
        $this->recipeRepository = $this->createMock(RecipeRepository::class);
        $this->controller = new RecipesController($this->recipeRepository);
        $this->controller->withTemplateEngine($this->engine);
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->request->method("getQueryParams")->willReturn([]);
    }

    public function testAllRecipes(): void
    {
        $this->recipeRepository->method('all')->willReturn([]);
        $this->engine
            ->method('parse')
            ->with('recipes/all.html.twig')
            ->willReturn($this->engine);

        $this->engine
            ->method('process')
            ->with(['recipes' => [], 'query' => null])->willReturn('Test html');
        $response = $this->controller->allRecipes($this->request);
        $this->assertEquals('Test html', (string) $response->getBody());
    }

    public function testSearchRecipes(): void
    {
        $token = 'oil';
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['q' => $token]);
        $this->recipeRepository->method('searchBy')->with($token)->willReturn([]);
        $this->engine
            ->method('parse')
            ->with('recipes/all.html.twig')
            ->willReturn($this->engine);

        $this->engine
            ->method('process')
            ->with(['recipes' => [], 'query' => $token])->willReturn('Test html');

        $response = $this->controller->allRecipes($request);
        $this->assertEquals('Test html', (string) $response->getBody());
    }

    public function testReadRecipe(): void
    {
        $recipe = $this->createMock(Recipe::class);
        $recipeId = md5('test');
        $this->recipeRepository->method('withRecipeId')->with($recipeId)->willReturn($recipe);
        $this->request->method('getHeaderLine')->with('Referer')->willReturn('');

        $this->engine
            ->method('parse')
            ->with('recipes/recipe.html.twig')
            ->willReturn($this->engine);

        $this->engine
            ->method('process')
            ->with(['recipe' => $recipe, 'referer' => ''])->willReturn('Test html');

        $response = $this->controller->recipe($recipeId, $this->request);
        $this->assertEquals('Test html', (string) $response->getBody());
    }
}
