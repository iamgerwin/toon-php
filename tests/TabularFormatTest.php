<?php

declare(strict_types=1);

use iamgerwin\Toon\EncodeOptions;
use iamgerwin\Toon\Toon;

it('encodes tabular arrays', function () {
    $data = [
        ['name' => 'John', 'age' => 30],
        ['name' => 'Jane', 'age' => 25],
    ];

    $encoded = Toon::tabular($data);
    expect($encoded)->toContain('{');
    expect($encoded)->toContain('name,age');
});

it('decodes tabular arrays', function () {
    $toon = <<<'TOON'
[2]{name,age}:
  John,30
  Jane,25
TOON;

    $result = Toon::decode($toon);
    expect($result)->toHaveCount(2);
    expect($result[0])->toBe(['name' => 'John', 'age' => 30]);
    expect($result[1])->toBe(['name' => 'Jane', 'age' => 25]);
});

it('handles tabular format with length marker', function () {
    $data = [
        ['id' => 1, 'status' => 'active'],
        ['id' => 2, 'status' => 'inactive'],
        ['id' => 3, 'status' => 'pending'],
    ];

    $options = EncodeOptions::tabular();
    $encoded = Toon::encode($data, $options);

    expect($encoded)->toContain('[3]');
    expect($encoded)->toContain('id,status');

    $decoded = Toon::decode($encoded);
    expect($decoded)->toBe($data);
});

it('detects uniform arrays for tabular format', function () {
    $data = [
        ['x' => 1, 'y' => 2],
        ['x' => 3, 'y' => 4],
        ['x' => 5, 'y' => 6],
    ];

    $encoded = Toon::tabular($data);
    $decoded = Toon::decode($encoded);

    expect($decoded)->toBe($data);
});

it('handles non-uniform arrays gracefully', function () {
    $data = [
        ['name' => 'John', 'age' => 30],
        ['name' => 'Jane', 'email' => 'jane@example.com'],
    ];

    $encoded = Toon::encode($data);
    $decoded = Toon::decode($encoded);

    expect($decoded)->toBeArray();
});
