<?php

/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Recipe;
use App\Domain\RecipeRepository;
use Slick\Di\Exception\NotFoundException;

/**
 * JsonRecipeRepository
 *
 * @package App\Infrastructure
 */
final class JsonRecipeRepository implements RecipeRepository
{
    /**
     * @var array<Recipe>
     */
    private array $recipes = [];

    public function __construct()
    {
        $file = file_get_contents(dirname(__DIR__, 2) . '/data/recipes.json');
        if (is_string($file)) {
            $data = json_decode($file);
            if (is_array($data)) {
                $this->recipes = [];
                foreach ($data as $item) {
                    $this->recipes[] = new Recipe((object) $item);
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function withRecipeId(string $recipeId): Recipe
    {
        foreach ($this->recipes as $recipe) {
            if ($recipe->recipeId() === $recipeId) {
                return $recipe;
            }
        }

        throw new NotFoundException("Recipe with id '$recipeId' not found");
    }

    /**
     * @inheritDoc
     * @return array<Recipe>
     */
    public function all(): array
    {
        return$this->recipes;
    }

    /**
     * @inheritDoc
     */
    public function searchBy(string $token): array
    {
        return array_filter($this->recipes, function (Recipe $recipe) use ($token) {
            if (in_array($token, $recipe->ingredients())) {
                return true;
            }

            $isTokenInName = str_contains(strtolower($recipe->name()), strtolower($token));
            $isTokenInInstructions = str_contains(strtolower($recipe->instructions()), strtolower($token));

            return $isTokenInName || $isTokenInInstructions;
        });
    }
}
