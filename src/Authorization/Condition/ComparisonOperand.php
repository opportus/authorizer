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

use Opportus\Authorizer\Authorization\Condition\Exception\Exception;

class ComparisonOperand implements ComparisonOperandInterface
{
    private const STRING_REGEX_PATTERN = '/^(\w+)$/';

    private string $string;

    /**
     * @param string $string
     * @throws Exception
     */
    public function __construct(string $string)
    {
        if (!\preg_match(self::getStringRegexPattern(), $string)) {
            throw new Exception(\sprintf(
                'String %s does not match regex pattern %s',
                $string,
                self::STRING_REGEX_PATTERN
            ));
        }

        $this->string = $string;
    }

    /**
     * @inheritDoc
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @inheritDoc
     */
    public static function getStringRegexPattern(): string
    {
        return self::STRING_REGEX_PATTERN;
    }
}
