<?php
/*
 * This file is part of the opportus/authorizer project.
 *
 * Copyright (c) 2022-2022 Clément Cazaud <clement.cazaud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Opportus\Authorizer\Authorization\Condition;

use Opportus\Authorizer\Authorization\LexicalTokenInterface;
use Opportus\Authorizer\ObjectPropertyAccessor\Exception\Exception;
use Opportus\Authorizer\ObjectPropertyAccessor\ObjectPropertyAccessorInterface;
use Opportus\Authorizer\ProfileInterface;

interface ComparisonConditionInterface extends LexicalTokenInterface
{
    /**
     * @param object                          $resource
     * @param ProfileInterface                $profile
     * @param ObjectPropertyAccessorInterface $objectPropertyAccessor
     * @return bool
     * @throws Exception
     */
    public function matches(
        object $resource,
        ProfileInterface $profile,
        ObjectPropertyAccessorInterface $objectPropertyAccessor
    ): bool;
}
