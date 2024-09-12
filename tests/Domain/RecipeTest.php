<?php
/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\App\Domain;

use App\Domain\Recipe;
use PHPUnit\Framework\TestCase;

class RecipeTest extends TestCase
{
    private Recipe $recipe;
    private $name;
    private $ingredients;
    private $instructions;
    private $imagePath;

    public function setUp(): void
    {
        $this->name = "Garlic Butter Shrimp";
        $this->ingredients = ["Shrimp", "garlic", "butter", "lemon juice", "parsley", "salt", "black pepper"];
        $this->instructions = "Sauté garlic in butter until fragrant. Add shrimp, lemon juice, salt, and pepper. Cook until " .
            "shrimp is pink. Garnish with parsley.";
        $this->imagePath = "/assets/recipe/4.jpg";
        $data = (object) [
            "name" => $this->name,
            "ingredients" => $this->ingredients,
            "instructions" => $this->instructions,
            "image" => $this->imagePath
        ];
        $this->recipe = new Recipe($data);
    }

    public function testIsInitializable(): void
    {
        $this->assertInstanceOf(Recipe::class, $this->recipe);
    }

    public function testRecipeId(): void
    {
        $this->assertEquals(md5($this->name), $this->recipe->recipeId());
    }

    public function testName(): void
    {
        $this->assertEquals($this->name, $this->recipe->name());
    }

    public function testIngredients(): void
    {
        $this->assertEquals($this->ingredients, $this->recipe->ingredients());
    }

    public function testInstructions(): void
    {
        $this->assertEquals($this->instructions, $this->recipe->instructions());
    }

    public function testImagePath(): void
    {
        $this->assertEquals($this->imagePath, $this->recipe->imagePath());
    }
}
