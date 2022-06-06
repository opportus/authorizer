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
use Opportus\Authorizer\ObjectPropertyAccessor\ObjectPropertyAccessorInterface;
use Opportus\Authorizer\ProfileInterface;

class ComparisonCondition implements ComparisonConditionInterface
{
    private const STRING_REGEX_PATTERN = '/^\?(\w+)(=|!=|<|>|<=|>=)(\w+)$/';

    private string $string;
    private ComparisonOperandInterface $resourcePropertyOperand;
    private ComparisonOperatorInterface $comparisonOperator;
    private ComparisonOperandInterface $profilePropertyOperand;

    /**
     * @param string $string
     * @throws Exception
     */
    public function __construct(string $string)
    {
        if (!\preg_match(self::getStringRegexPattern(), $string, $matches)) {
            throw new Exception(\sprintf(
                'String %s does not match regex pattern %s',
                $string,
                self::STRING_REGEX_PATTERN
            ));
        }

        $this->string = $string;

        $this->resourcePropertyOperand = new ComparisonOperand($matches[1]);
        $this->comparisonOperator = new ComparisonOperator($matches[2]);
        $this->profilePropertyOperand = new ComparisonOperand($matches[3]);
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

    /**
     * @inheritDoc
     */
    public function matches(
        object $resource,
        ProfileInterface $profile,
        ObjectPropertyAccessorInterface $objectPropertyAccessor
    ): bool {
        return $this->comparisonOperator->operate(
            $objectPropertyAccessor->accessObjectProperty($this->resourcePropertyOperand->getString(), $resource),
            $objectPropertyAccessor->accessObjectProperty($this->profilePropertyOperand->getString(), $profile)
        );
    }
}
