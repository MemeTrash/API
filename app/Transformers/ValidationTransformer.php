<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Generators\ValidationException;
use Exception;
use GrahamCampbell\Exceptions\Transformers\TransformerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * This is the validation transformer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ValidationTransformer implements TransformerInterface
{
    /**
     * Transform the provided exception.
     *
     * @param \Exception $exception
     *
     * @return \Exception
     */
    public function transform(Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            $exception = new BadRequestHttpException($exception->getMessage());
        }

        return $exception;
    }
}
