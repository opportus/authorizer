<?php
/*
 * This file is part of the opportus/authorizer project.
 *
 * Copyright (c) 2022-2022 Clément Cazaud <clement.cazaud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Opportus\Authorizer\Tests;

use Opportus\Authorizer\ProfileInterface;

class TestProfile implements ProfileInterface
{
    private string $email;
    private int $age;
    private array $perimeters;
    private array $authorizations;

    /**
     * @param string $email
     * @param int    $age
     * @param array  $perimeters
     * @param array  $authorizations
     */
    public function __construct(string $email, int $age, array $perimeters, array $authorizations)
    {
        $this->email = $email;
        $this->age = $age;
        $this->perimeters = $perimeters;
        $this->authorizations = $authorizations;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return array
     */
    public function getPerimeters(): array
    {
        return $this->perimeters;
    }

    /**
     * @inheritDoc
     */
    public function getAuthorizations(): array
    {
        return $this->authorizations;
    }
}
