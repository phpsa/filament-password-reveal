<?php

namespace Phpsa\FilamentPasswordReveal\Traits;

use Closure;
use Illuminate\Support\Arr;

trait CanGenerate
{
    protected string $generateIcon = 'heroicon-o-key';

    protected bool|Closure  $generatable = false;

    protected int $passwordMinLen = 8;

    protected bool $passwordUsesNumbers = true;

    protected bool $passwordUsesSymbols = true;

    protected ?string $generateText = null;

    protected bool|Closure $notifyOnGenerate = false;

    public function generatable(bool|Closure $condition = true): static
    {
        $this->generatable = $condition;

        return $this;
    }

    public function generateIcon(string $icon): static
    {
        $this->generateIcon = $icon;

        return $this;
    }

    public function generateText(string|Closure $text): static
    {
        $this->generateText = $text;

        return $this;
    }

    public function notifyOnGenerate(bool|Closure $notifyOnGenerate = true): static
    {
        $this->notifyOnGenerate = $notifyOnGenerate;

        return $this;
    }

    public function getGenerateIcon(): string
    {
        return $this->generateIcon;
    }

    public function isGeneratable(): bool
    {
        return (bool) $this->evaluate($this->generatable);
    }

    public function passwordLength(int $len): static
    {
        $this->passwordMinLen = $len;
        return $this;
    }

    public function passwordUsesNumbers(bool $use = true): static
    {
        $this->passwordUsesNumbers = $use;
        return $this;
    }

    public function passwordUsesSymbols(bool $use = true): static
    {
        $this->passwordUsesSymbols = $use;
        return $this;
    }

    public function getPasswLength(): int
    {
        return $this->passwordMinLen;
    }

    public function getPasswChars(): string
    {
        return collect(range('a', 'z'))
            ->merge(range('A', 'Z'))
             ->when($this->passwordUsesNumbers, fn($chars) => $chars->merge(range(0, 9)))
            ->when($this->passwordUsesSymbols, fn($chars) => $chars->merge(['!#$%&()*+,-./:;<=>?@[\]^_`{|}~']))
            ->join('');
    }

    public function getGenerateText(): string
    {
        return $this->evaluate($this->generateText ?? __('Password generated'));
    }

    public function shouldNotifyOnGenerate(): bool {
        return $this->evaluate($this->notifyOnGenerate);
    }
}
