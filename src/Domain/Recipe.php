<?php

/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

/**
 * Recipe
 *
 * @package App\Domain
 */
class Recipe
{

    private string $recipeId;

    private string $name;

    /**
     * @var array<string>
     */
    private array $ingredients;

    private string $instructions;

    private string $imagePath;

    /**
     *  Create a recipe
     *
     * @param object{name: string, ingredients: array<string>, instructions: string, image: string} $data
     */
    public function __construct(object $data)
    {
        $this->recipeId = md5($data->name);
        $this->name = $data->name;
        $this->ingredients = $data->ingredients;
        $this->instructions = $data->instructions;
        $this->imagePath = $data->image;
    }

    public function recipeId(): string
    {
        return $this->recipeId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function ingredients(): array
    {
        return $this->ingredients;
    }

    public function instructions(): string
    {
        return $this->instructions;
    }

    public function imagePath(): string
    {
        return $this->imagePath;
    }
}
