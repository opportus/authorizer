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

use Opportus\Authorizer\Authorization\AuthorizationFactory;
use Opportus\Authorizer\Authorization\Exception\Exception;
use Opportus\Authorizer\Authorizer;
use Opportus\Authorizer\ObjectPropertyAccessor\ObjectPropertyAccessor;
use PHPUnit\Framework\TestCase;

class AuthorizerTest extends TestCase
{
    public function testAuthorize()
    {
        $authorizer = new Authorizer(new ObjectPropertyAccessor());

        $admin1  = new TestProfile('admin1@test.net',  23, ['net'], $this->createAdminRole());
        $author1 = new TestProfile('author1@test.net', 56, ['net'], $this->createAuthorRole());
        $reader1 = new TestProfile('reader1@test.net', 18, ['net'], $this->createReaderRole());

        $resource1 = new TestResource($author1->getEmail(), 18, 'net');

        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile('create', $resource1, $admin1));
        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile('read',   $resource1, $admin1));
        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile('update', $resource1, $admin1));
        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile('delete', $resource1, $admin1));
        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile('share',  $resource1, $admin1));

        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile( 'create', $resource1, $author1));
        self::assertFalse($authorizer->authorizeOperationOnResourceByProfile( 'read',   $resource1, $author1));
        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile( 'update', $resource1, $author1));
        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile( 'delete', $resource1, $author1));
        self::assertFalse($authorizer->authorizeOperationOnResourceByProfile('share',  $resource1, $author1));

        self::assertFalse($authorizer->authorizeOperationOnResourceByProfile('create', $resource1, $reader1));
        self::assertTrue($authorizer->authorizeOperationOnResourceByProfile( 'read',   $resource1, $reader1));
        self::assertFalse($authorizer->authorizeOperationOnResourceByProfile('update', $resource1, $reader1));
        self::assertFalse($authorizer->authorizeOperationOnResourceByProfile('delete', $resource1, $reader1));
        self::assertFalse($authorizer->authorizeOperationOnResourceByProfile('share',  $resource1, $reader1));
    }

    /**
     * @return array
     * @throws Exception
     */
    private function createAdminRole(): array
    {
        $authorizationFactory = new AuthorizationFactory();

        return [
            $authorizationFactory->createAuthorization('*-'.TestResource::class),
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function createAuthorRole(): array
    {
        $authorizationFactory = new AuthorizationFactory();

        return [
            $authorizationFactory->createAuthorization('create-'.TestResource::class),
            $authorizationFactory->createAuthorization('update-'.TestResource::class.'?author=email'),
            $authorizationFactory->createAuthorization('delete-'.TestResource::class.'?author=email'),
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function createReaderRole(): array
    {
        $authorizationFactory = new AuthorizationFactory();

        return [
            $authorizationFactory->createAuthorization('read-'.TestResource::class.'?restrictionAge<=age'),
        ];
    }
}
