<?php

declare(strict_types=1);

it('has toon helper function', function () {
    $data = ['foo' => 'bar'];
    $result = toon($data);
    expect($result)->toBeString();
    expect($result)->toContain('foo:');
});

it('has toon_decode helper function', function () {
    $toon = 'foo: bar';
    $result = toon_decode($toon);
    expect($result)->toBe(['foo' => 'bar']);
});

it('has toon_compact helper function', function () {
    $data = ['foo' => 'bar'];
    $result = toon_compact($data);
    expect($result)->toBeString();
});

it('has toon_readable helper function', function () {
    $data = ['foo' => 'bar'];
    $result = toon_readable($data);
    expect($result)->toBeString();
});

it('has toon_tabular helper function', function () {
    $data = [['x' => 1], ['x' => 2]];
    $result = toon_tabular($data);
    expect($result)->toBeString();
});

it('has toon_compare helper function', function () {
    $data = ['foo' => 'bar'];
    $result = toon_compare($data);
    expect($result)->toHaveKeys(['toon', 'json', 'toon_tokens', 'json_tokens', 'savings_percent']);
});

it('has toon_estimate_tokens helper function', function () {
    $result = toon_estimate_tokens('hello world');
    expect($result)->toBeInt();
    expect($result)->toBeGreaterThan(0);
});
