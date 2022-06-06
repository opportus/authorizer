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

use Opportus\Authorizer\Authorization\Condition\ComparisonCondition;
use Opportus\Authorizer\Authorization\Condition\ComparisonConditionInterface;
use Opportus\Authorizer\Authorization\Exception\Exception;
use Opportus\Authorizer\ObjectPropertyAccessor\ObjectPropertyAccessorInterface;
use Opportus\Authorizer\ProfileInterface;

class ConditionalAuthorization implements ConditionalAuthorizationInterface
{
    private const STRING_REGEX_PATTERN = '/^(\w+|\*)-([\w\\\]+|\*)((\?)(\w+)(=|!=|<|>|<=|>=)(\w+))$/';

    private string $string;
    private OperationInterface $operation;
    private ResourceInterface $resource;
    private ComparisonConditionInterface $condition;

    /**
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

        $this->operation = new Operation($matches[1]);
        $this->resource = new Resource($matches[2]);
        $this->condition = new ComparisonCondition($matches[3]);
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
        string $operation,
        object $resource,
        ProfileInterface $profile,
        ObjectPropertyAccessorInterface $objectPropertyAccessor
    ): bool {
        return $this->operation->matches($operation)
            && $this->resource->matches($resource)
            && $this->condition->matches($resource, $profile, $objectPropertyAccessor);
    }
}
