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
    public function allRecipes(): ResponseInterface
    {
        return $this->render("recipes/all.html.twig", ['recipes' => $this->recipes->all()]);
    }
}
