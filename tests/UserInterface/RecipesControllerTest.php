<?php
/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\App\UserInterface;

use App\Domain\RecipeRepository;
use App\UserInterface\RecipesController;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slick\Template\TemplateEngineInterface;

class RecipesControllerTest extends TestCase
{
    private TemplateEngineInterface&MockObject $engine;
    private RecipeRepository&MockObject $recipeRepository;

    private RecipesController $controller;
    function setUp(): void
    {
        $this->engine = $this->createMock(TemplateEngineInterface::class);
        $this->recipeRepository = $this->createMock(RecipeRepository::class);
        $this->controller = new RecipesController($this->recipeRepository);
        $this->controller->withTemplateEngine($this->engine);
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
            ->with(['recipes' => []])->willReturn('Test html');
        $response = $this->controller->allRecipes();
        $this->assertEquals('Test html', (string) $response->getBody());
    }
}
