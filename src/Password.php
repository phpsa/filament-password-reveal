<?php

namespace Phpsa\FilamentPasswordReveal;

use Filament\Forms\Components\TextInput;

class Password extends TextInput
{
    protected string $view = 'filament-password-reveal::password';

    protected string $showIcon = 'heroicon-o-eye';
    protected string $hideIcon = 'heroicon-o-eye-off';
    protected string $copyIcon = 'heroicon-o-clipboard';

    protected bool $copyable = false;

    public function copyable($value = true): static
    {
        $this->copyable = $value;

        return $this;
    }

    public function showIcon(string $icon): static
    {
        $this->showIcon = $icon;

        return $this;
    }

    public function hideIcon(string $icon): static
    {
        $this->hideIcon = $icon;

        return $this;
    }

    public function copyIcon(string $icon): static
    {
        $this->copyIcon = $icon;

        return $this;
    }

    public function getShowIcon(): string {
        return $this->showIcon;
    }

    public function getHideIcon(): string {
        return $this->hideIcon;
    }

    public function getCopyIcon(): string {
        return $this->copyIcon;
    }

    public function isCopyable(): bool {
        return $this->copyable;
    }
}
