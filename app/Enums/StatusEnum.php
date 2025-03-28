<?php

declare(strict_types=1);

namespace App\Enums;

enum StatusEnum: int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case IN_PROGRESS = 2;
    case CANCELLED = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
            self::IN_PROGRESS => 'In Progress',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::COMPLETED => 'green',
            self::IN_PROGRESS => 'blue',
            self::CANCELLED => 'red',
        };
    }
}
