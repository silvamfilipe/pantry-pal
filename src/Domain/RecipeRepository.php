<?php

/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\RecipeNotFound;

/**
 * RecipeRepository
 *
 * @package App\Domain
 */
interface RecipeRepository
{

    /**
     * Retrieves the recipe stored with provided recipe identifier
     *
     * @param string $recipeId The ID of the recipe.
     * @return Recipe The Recipe stored with provided identifier
     * @throws DomainException|RecipeNotFound When there are no recipes with provided identifier
     */
    public function withRecipeId(string $recipeId): Recipe;

    /**
     * Returns all items in the database
     *
     * @return array<Recipe> An array containing all items
     */
    public function all(): array;

    /**
     * Searches the recipe database for recipes matching the given token
     *
     * @param string $token The token to search by
     * @return array<Recipe> An array containing recipes matching the token
     */
    public function searchBy(string $token): array;
}
