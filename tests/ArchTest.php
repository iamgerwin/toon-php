<?php

arch('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

arch('ensures all classes use strict types')
    ->expect('iamgerwin\Toon')
    ->toUseStrictTypes();

arch('ensures no classes extend from base classes unnecessarily')
    ->expect('iamgerwin\Toon')
    ->classes()
    ->not->toBeAbstract();

arch('ensures exceptions are in the Exceptions namespace')
    ->expect('iamgerwin\Toon\Exceptions')
    ->toExtend(Exception::class);
