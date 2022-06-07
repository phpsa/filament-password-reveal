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

    public function getGenerateIcon(): string
    {
        return $this->generateIcon;
    }

    public function isGeneratable(): bool
    {
        return (bool) $this->evaluate($this->generatable);
    }

    public function passwordLength(int $len)
    {
        $this->passwordMinLen = $len;
    }

    public function passwordUsesNumbers(bool $use = true)
    {
        $this->passwordUsesNumbers = $use;
    }

    public function passwordUsesSymbols(bool $use = true)
    {
        $this->passwordUsesSymbols = $use;
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
}
