<?php
/*
 * This file is part of the opportus/authorizer project.
 *
 * Copyright (c) 2022-2022 Clément Cazaud <clement.cazaud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Opportus\Authorizer\ObjectPropertyAccessor;

use Opportus\Authorizer\ObjectPropertyAccessor\Exception\Exception;

final class ObjectPropertyAccessor implements ObjectPropertyAccessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function accessObjectProperty(string $property, object $object)
    {
        $objectReflection = new \ReflectionObject($object);
        $getterName = \sprintf('get%s', \ucfirst($property));

        if (!$objectReflection->hasMethod($getterName)) {
            throw new Exception(\sprintf(
                'Object of class %s does not have a getter method %s corresponding to property %s',
                \get_class($object),
                $getterName,
                $property
            ));
        }

        $getterReflection = $objectReflection->getMethod($getterName);

        if (!$getterReflection->isPublic()) {
            throw new Exception(\sprintf(
                'Object of class %s does not have a getter method %s which is public',
                \get_class($object),
                $getterName
            ));
        }

        if ($getterReflection->getNumberOfRequiredParameters() !== 0) {
            throw new Exception(\sprintf(
                'Object of class %s has a getter method %s which require parameters',
                \get_class($object),
                $getterName
            ));
        }

        try {
            $value = $getterReflection->invoke($object);
        } catch (\Throwable $exception) {
            throw new Exception(\sprintf(
                'Cannot invoke getter %s from object of class %s',
                $getterName,
                \get_class($object)
            ));
        }

        return $value;
    }
}
