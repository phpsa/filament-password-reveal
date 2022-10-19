<?php

namespace Phpsa\FilamentPasswordReveal\Traits;

use Closure;

trait CanCopy
{
    protected bool|Closure  $copyable = false;

    protected string $copyIcon = 'heroicon-o-clipboard';

    protected ?string $copyText = null;

    protected bool|Closure $notifyOnCopy = true;

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

    public function copyText(string|Closure $text): static
    {
        $this->copyText = $text;

        return $this;
    }

    public function notifyOnCopy(bool|Closure $notifyOnCopy = true): static
    {
        $this->notifyOnCopy = $notifyOnCopy;

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

    public function getCopyText(): string
    {
        return $this->evaluate($this->copyText ?? __('Copied to clipboard'));
    }

    public function shouldNotifyOnCopy(): bool {
        return $this->evaluate($this->notifyOnCopy);
    }
}
