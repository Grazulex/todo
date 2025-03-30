<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

final class Appearance extends Component
{
    #[Layout('components.layouts.app')]
    public function render(): View
    {
        return view('livewire.settings.appearance');
    }
}
