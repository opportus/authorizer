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

interface ObjectPropertyAccessorInterface
{
    /**
     * Fetches a datum from data.
     *
     * @param string $property
     * @param object $object
     * @throws Exception
     */
    public function accessObjectProperty(string $property, object $object);
}
