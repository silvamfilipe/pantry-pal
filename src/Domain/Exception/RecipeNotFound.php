<?php

/**
 * This file is part of pantry-pal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\DomainException;
use RuntimeException;

/**
 * RecipeNotFound
 *
 * @package App\Domain\Exception
 */
final class RecipeNotFound extends RuntimeException implements DomainException
{

}
