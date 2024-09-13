<?php

/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface;

use App\Domain\RecipeRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Template\UserInterface\TemplateMethods;
use Symfony\Component\Routing\Attribute\Route;

/**
 * RecipesController
 *
 * @package App\UserInterface
 */
final class RecipesController
{

    use TemplateMethods;

    public function __construct(private readonly RecipeRepository $recipes)
    {
    }

    #[Route(path: "/", name: "recipes")]
    public function allRecipes(ServerRequestInterface $request): ResponseInterface
    {
        $query = $this->retrieveQuery($request);
        return $this->render(
            "recipes/all.html.twig",
            [
                'recipes' => $query
                    ? $this->recipes->searchBy($query)
                    : $this->recipes->all(),
                'query' => $query
            ]
        );
    }

    #[Route(path: "/recipe/{recipeId}", name: "recipe")]
    public function recipe(string $recipeId, ServerRequestInterface $request): ResponseInterface
    {
        $referer = $request->getHeaderLine("Referer");
        $recipe = $this->recipes->withRecipeId(strip_tags($recipeId));
        return $this->render('recipes/recipe.html.twig', compact('recipe', 'referer'));
    }

    private function retrieveQuery(ServerRequestInterface $request): ?string
    {
        $query = $request->getQueryParams();
        if (!array_key_exists("q", $query)) {
            return null;
        }

        return strip_tags($query["q"]);
    }
}
