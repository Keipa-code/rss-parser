<?php

declare(strict_types=1);


namespace App\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;

final class JsonToPrettyJsonTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return json_encode(json_decode($value), JSON_PRETTY_PRINT);
    }

    public function reverseTransform($value)
    {
        return json_encode(json_decode($value));
    }
}