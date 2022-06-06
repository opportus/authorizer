<?php
/*
 * This file is part of the opportus/authorizer project.
 *
 * Copyright (c) 2022-2022 Clément Cazaud <clement.cazaud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Opportus\Authorizer;

use Opportus\Authorizer\Authorization\ConditionalAuthorizationInterface;
use Opportus\Authorizer\Authorization\BasicAuthorizationInterface;
use Opportus\Authorizer\ObjectPropertyAccessor\ObjectPropertyAccessorInterface;
use Opportus\Authorizer\Exception\Exception;

class Authorizer implements AuthorizerInterface
{
    private ObjectPropertyAccessorInterface $objectPropertyAccessor;

    /**
     * @param ObjectPropertyAccessorInterface $objectPropertyAccessor
     */
    public function __construct(ObjectPropertyAccessorInterface $objectPropertyAccessor)
    {
        $this->objectPropertyAccessor = $objectPropertyAccessor;
    }

    /**
     * @inheritDoc
     */
    public function authorizeOperationOnResourceByProfile(
        string $operation,
        object $resource,
        ProfileInterface $profile
    ): bool {
        $authorizations = $profile->getAuthorizations();

        foreach ($authorizations as $authorization) {
            if (!$authorization instanceof BasicAuthorizationInterface
                && !$authorization instanceof ConditionalAuthorizationInterface
            ) {
                throw new Exception(\sprintf(
                    'Expecting array of %s or %s instance elements but got an element of type %s',
                    BasicAuthorizationInterface::class,
                    ConditionalAuthorizationInterface::class,
                    \is_object($authorization) ? \get_class($authorization) : \gettype($authorization)
                ));
            }
        }

        foreach ($authorizations as $authorization) {
            if ($authorization instanceof BasicAuthorizationInterface) {
                if ($authorization->matches($operation, $resource)) {
                    return true;
                }
            } elseif ($authorization instanceof ConditionalAuthorizationInterface) {
                if ($authorization->matches($operation, $resource, $profile, $this->objectPropertyAccessor)) {
                    return true;
                }
            }
        }

        return false;
    }
}
