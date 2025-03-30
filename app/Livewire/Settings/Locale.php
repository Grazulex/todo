<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

final class Locale extends Component
{
    use LivewireAlert;

    public string $locale = '';

    public function mount(): void
    {
        $this->locale = auth()->user()->locale;
    }

    public function updateLocale(): void
    {
        $this->validate([
            'locale' => 'required|string|in:en,fr',
        ]);

        auth()->user()->update([
            'locale' => $this->locale,
        ]);

        $this->alert('success', __('global.saved'));

        $this->dispatch('locale-updated', name: auth()->user()->name);
    }

    #[Layout('components.layouts.app')]
    public function render(): View
    {
        return view('livewire.settings.locale', [
            'locales' => [
                'en' => 'English',
                'fr' => 'Français   ',
            ],
        ]);
    }
}
