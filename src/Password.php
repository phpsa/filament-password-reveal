<?php

namespace Phpsa\FilamentPasswordReveal;

use Closure;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Phpsa\FilamentPasswordReveal\Traits\CanCopy;
use Phpsa\FilamentPasswordReveal\Traits\CanGenerate;

class Password extends TextInput
{
    use CanCopy;
    use CanGenerate;

    protected array $extraAlpineAttributes = [
        ['show' => false]
    ];

    protected string $view = 'filament-password-reveal::password';

    protected string $showIcon = 'heroicon-o-eye';

    protected string $hideIcon = 'heroicon-o-eye-off';

    protected bool|Closure $revealable = true;

    protected bool|Closure  $initiallyHidden = true;

    public ?bool $revealPassword = null;

    public function getIsRevealed(): bool
    {
        if ($this->isRevealable() === false) {
            return false;
        }
        if ($this->revealPassword === null) {
            $this->revealPassword = ! $this->isInitiallyHidden();
        }

        return $this->revealPassword;
    }

    public function toggleReveal(): void
    {
        $this->revealPassword = ! $this->revealPassword;
    }

    public function revealable(bool|Closure $condition = true): static
    {
        $this->revealable = $condition;

        return $this;
    }

    public function initiallyHidden(bool|Closure $condition = true): static
    {
        $this->initiallyHidden = $condition;

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

    public function getShowIcon(): string
    {
        return $this->showIcon;
    }

    public function getHideIcon(): string
    {
        return $this->hideIcon;
    }

    public function isRevealable(): bool
    {
        return (bool) $this->evaluate($this->revealable);
    }

    public function isInitiallyHidden(): bool
    {
        return (bool) $this->evaluate($this->initiallyHidden);
    }

    public function getXRef(): string
    {
        return Str::of($this->getId())->replace(".", "_")->prepend('input_')->studly()->snake()->__toString();
    }
}
