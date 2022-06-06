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

use Opportus\Authorizer\Authorization\Condition\Exception\Exception;

class AuthorizationFactory implements AuthorizationFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createAuthorization(string $string): BasicAuthorizationInterface|ConditionalAuthorizationInterface
    {
        if (\preg_match(BasicAuthorization::getStringRegexPattern(), $string)) {
            return new BasicAuthorization($string);
        } elseif (\preg_match(ConditionalAuthorization::getStringRegexPattern(), $string)) {
            return new ConditionalAuthorization($string);
        } else {
            throw new Exception(\sprintf(
                'Given string %s does not comply to any supported type of authorization regex pattern:%s%s%s%s',
                $string,
                \PHP_EOL,
                BasicAuthorization::getStringRegexPattern(),
                \PHP_EOL,
                ConditionalAuthorization::getStringRegexPattern()
            ));
        }
    }
}
