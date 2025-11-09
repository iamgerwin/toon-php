<?php

declare(strict_types=1);

use iamgerwin\Toon\Toon;

it('encodes and decodes primitives correctly', function () {
    expect(Toon::encode(null))->toBe('null');
    expect(Toon::encode(true))->toBe('true');
    expect(Toon::encode(false))->toBe('false');
    expect(Toon::encode(42))->toBe('42');
    expect(Toon::encode(3.14))->toBe('3.14');
    expect(Toon::encode('hello'))->toBe('hello');
});

it('decodes primitives correctly', function () {
    expect(Toon::decode('null'))->toBeNull();
    expect(Toon::decode('true'))->toBeTrue();
    expect(Toon::decode('false'))->toBeFalse();
    expect(Toon::decode('42'))->toBe(42);
    expect(Toon::decode('3.14'))->toBe(3.14);
    expect(Toon::decode('hello'))->toBe('hello');
});

it('handles quoted strings', function () {
    $value = 'hello, world';
    $encoded = Toon::encode($value);
    expect($encoded)->toContain('"');
    expect(Toon::decode($encoded))->toBe($value);
});

it('encodes simple arrays', function () {
    $array = [1, 2, 3];
    $encoded = Toon::encode($array);
    expect($encoded)->toContain('[3]:');
    expect($encoded)->toContain('1,2,3');
});

it('decodes simple arrays', function () {
    $toon = '[3]: 1,2,3';
    $result = Toon::decode($toon);
    expect($result)->toBe([1, 2, 3]);
});

it('encodes objects', function () {
    $object = ['name' => 'John', 'age' => 30];
    $encoded = Toon::encode($object);
    expect($encoded)->toContain('name:');
    expect($encoded)->toContain('age:');
});

it('decodes objects', function () {
    $toon = <<<'TOON'
name: John
age: 30
TOON;
    $result = Toon::decode($toon);
    expect($result)->toBe(['name' => 'John', 'age' => 30]);
});

it('handles nested objects', function () {
    $data = [
        'user' => [
            'name' => 'John',
            'email' => 'john@example.com',
        ],
    ];
    $encoded = Toon::encode($data);
    $decoded = Toon::decode($encoded);
    expect($decoded)->toBe($data);
});

it('uses compact format', function () {
    $data = ['name' => 'John', 'age' => 30];
    $compact = Toon::compact($data);
    expect(strlen($compact))->toBeLessThan(strlen(Toon::readable($data)));
});

it('estimates tokens correctly', function () {
    $text = 'hello world';
    $tokens = Toon::estimateTokens($text);
    expect($tokens)->toBeGreaterThan(0);
    expect($tokens)->toBe((int) ceil(strlen($text) / 4));
});

it('compares with JSON', function () {
    $data = ['name' => 'John', 'age' => 30, 'active' => true];
    $comparison = Toon::compare($data);

    expect($comparison)->toHaveKeys(['toon', 'json', 'toon_tokens', 'json_tokens', 'savings_percent']);
    expect($comparison['toon_tokens'])->toBeGreaterThan(0);
    expect($comparison['json_tokens'])->toBeGreaterThan(0);
});

it('handles DateTime objects', function () {
    $date = new DateTime('2024-01-01 12:00:00');
    $encoded = Toon::encode(['date' => $date]);
    expect($encoded)->toContain('date:');
    expect($encoded)->toContain('2024-01-01');
});

// Enum test removed for PHP 7.0-8.0 compatibility
// Enums are only supported in PHP 8.1+

it('handles empty arrays', function () {
    $encoded = Toon::encode([]);
    expect($encoded)->toBe('[]');

    $decoded = Toon::decode('[]');
    expect($decoded)->toBe([]);
});

it('handles INF and NAN as null', function () {
    expect(Toon::encode(INF))->toBe('null');
    expect(Toon::encode(NAN))->toBe('null');
});

it('handles arrays with mixed types', function () {
    $data = [1, 'two', 3.14, true, null];
    $encoded = Toon::encode($data);
    $decoded = Toon::decode($encoded);
    expect($decoded)->toBe($data);
});

it('preserves numeric keys', function () {
    $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
    $encoded = Toon::encode($data);
    $decoded = Toon::decode($encoded);
    expect($decoded)->toBe(['zero', 'one', 'two']);
});
