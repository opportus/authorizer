# Authorizer

[![License](https://poser.pugx.org/opportus/authorizer/license)](https://packagist.org/packages/opportus/authorizer)
[![Latest Stable Version](https://poser.pugx.org/opportus/authorizer/v/stable)](https://packagist.org/packages/opportus/authorizer)
[![Latest Unstable Version](https://poser.pugx.org/opportus/authorizer/v/unstable)](https://packagist.org/packages/opportus/authorizer)
[![Build](https://github.com/opportus/authorizer/workflows/Build/badge.svg)](https://github.com/opportus/authorizer/actions?query=workflow%3ABuild)

**Index**

- [Introduction](#introduction)
- [Roadmap](#roadmap)
    - [v1.1](#v11)
- [Integrations](#integrations)
- [Setup](#setup)
    - [Step 1 - Installation](#step-1---installation)
    - [Step 2 - Initialization](#step-2---initialization)
- [Authorization](#authorization)
    - [Concept](#concept)
    - [Example Use Cases](#example-use-cases)

## Introduction

This library provides a generic and standardizable authorization system.

## Roadmap

To develop this solution faster, [contributions](https://github.com/opportus/authorizer/blob/master/.github/CONTRIBUTING.md) are welcome...

v1.1:
- Implement property chain access support
- Implement multiple condition authorization support
- Implement multiple comparison operators support
- Implement higher test coverage

## Integrations

- {{ reference_here_your_own_integration }}

## Setup

### Step 1 - Installation

Open a command console, enter your project directory and execute:

```console
$ composer require opportus/authorizer
```

### Step 2 - Initialization

This library contains 4 services. 3 of them require a single dependency which is
another lower level service among those 4:

```php
use Opportus\Authorizer\Authorizer;
use Opportus\Authorizer\ObjectPropertyAccessor\ObjectPropertyAccessor;

$objectPropertyAccessor = new ObjectPropertyAccessor();
$authorizer             = new Authorizer($objectPropertyAccessor);
```

In order for the authorizer to get properly initialized, each of its services it
depends on must be instantiated such as above.

By design, this solution does not provide "helpers" for the instantiation of
its own services which is much better handled the way you're already
instantiating your own services, with a DIC system or whatever.

## Authorization

### Concept

An **authorization** is a *use case* assigned to an *actor* of your system.

An **authorization** is composed of:

- an **operation**
- (on) a **resource**
- (under) an optional **condition**

### Example Use Cases

...
