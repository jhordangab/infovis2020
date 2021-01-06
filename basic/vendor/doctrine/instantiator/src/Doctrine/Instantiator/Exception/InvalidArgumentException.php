<?php
namespace Doctrine\Instantiator\Exception;

use InvalidArgumentException as BaseInvalidArgumentException;
use ReflectionClass;

/**
 * Exception for invalid arguments provided to the instantiator
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class InvalidArgumentException extends BaseInvalidArgumentException implements ExceptionInterface
{
    public static function fromNonExistingClass(string $className) : self
    {
        if (interface_exists($className)) {
            return new self(sprintf('The provided type "%s" is an interface, and can not be instantiated', $className));
        }

        if (PHP_VERSION_ID >= 50400 && trait_exists($className)) {
            return new self(sprintf('The provided type "%s" is a trait, and can not be instantiated', $className));
        }

        return new self(sprintf('The provided class "%s" does not exist', $className));
    }

    public static function fromAbstractClass(ReflectionClass $reflectionClass) : self
    {
        return new self(sprintf(
            'The provided class "%s" is abstract, and can not be instantiated',
            $reflectionClass->getName()
        ));
    }
}
