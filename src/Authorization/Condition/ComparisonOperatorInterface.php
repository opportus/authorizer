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

interface ComparisonOperatorInterface extends LexicalTokenInterface
{
    /**
     * @param $leftOperand
     * @param $rightOperand
     * @return bool
     */
    public function operate($leftOperand, $rightOperand): bool;
}
