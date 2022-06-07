<?php

namespace Phpsa\FilamentPasswordReveal\Traits;

use Closure;

trait CanCopy
{
    protected bool|Closure  $copyable = false;

    protected string $copyIcon = 'heroicon-o-clipboard';

    public function copyable(bool|Closure $condition = true): static
    {
        $this->copyable = $condition;

        return $this;
    }

    public function copyIcon(string $icon): static
    {
        $this->copyIcon = $icon;

        return $this;
    }

    public function isCopyable(): bool
    {
        return (bool) $this->evaluate($this->copyable);
    }

    public function getCopyIcon(): string
    {
        return $this->copyIcon;
    }
}
