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

class TestResource
{
    private string $author;
    private int $restrictionAge;
    private string $domain;

    /**
     * @param string $author
     * @param int    $restrictionAge
     * @param string $operatingScope
     */
    public function __construct(string $author, int $restrictionAge, string $operatingScope)
    {
        $this->author = $author;
        $this->restrictionAge = $restrictionAge;
        $this->domain = $operatingScope;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getRestrictionAge(): int
    {
        return $this->restrictionAge;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }
}
