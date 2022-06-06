<?php
/*
 * This file is part of the opportus/authorizer project.
 *
 * Copyright (c) 2022-2022 Clément Cazaud <clement.cazaud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Opportus\Authorizer\Authorization;

interface BasicAuthorizationInterface extends LexicalTokenInterface
{
    /**
     * @param string $operation
     * @param object $resource
     * @return bool
     */
    public function matches(string $operation, object $resource): bool;
}
