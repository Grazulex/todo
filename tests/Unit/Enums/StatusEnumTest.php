<?php

declare(strict_types=1);

test('returns correct label for in progress status', function (): void {
    $status = App\Enums\StatusEnum::IN_PROGRESS;
    $this->assertEquals('In Progress', $status->getLabel());
});

test('returns correct label for cancelled status', function (): void {
    $status = App\Enums\StatusEnum::CANCELLED;
    $this->assertEquals('Cancelled', $status->getLabel());
});

test('returns correct color for pending status', function (): void {
    $status = App\Enums\StatusEnum::PENDING;
    $this->assertEquals('gray', $status->getColor());
});

test('returns correct color for completed status', function (): void {
    $status = App\Enums\StatusEnum::COMPLETED;
    $this->assertEquals('green', $status->getColor());
});

test('returns correct color for in progress status', function (): void {
    $status = App\Enums\StatusEnum::IN_PROGRESS;
    $this->assertEquals('blue', $status->getColor());
});

test('returns correct color for cancelled status', function (): void {
    $status = App\Enums\StatusEnum::CANCELLED;
    $this->assertEquals('red', $status->getColor());
});
