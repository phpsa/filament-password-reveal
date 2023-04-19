@php
$datalistOptions = $getDatalistOptions();

$sideLabelClasses = ['whitespace-nowrap group-focus-within:text-primary-500', 'text-gray-400' => !$errors->has($getStatePath()), 'text-danger-400' => $errors->has($getStatePath())];

$affixLabelClasses = ['whitespace-nowrap group-focus-within:text-primary-500', 'text-gray-400' => !$errors->has($getStatePath()), 'text-danger-400' => $errors->has($getStatePath())];
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div
        {{ $attributes->merge($getExtraAttributes())->class(['flex items-center space-x-2 rtl:space-x-reverse group filament-forms-text-input-component']) }}>
        @if (($prefixAction = $getPrefixAction()) && !$prefixAction->isHidden())
            {{ $prefixAction }}
        @endif

        @if ($icon = $getPrefixIcon())
            <x-dynamic-component
                :component="$icon"
                class="h-5 w-5"
            />
        @endif

        @if ($label = $getPrefixLabel())
            <span @class($sideLabelClasses)>
                {{ $label }}
            </span>
        @endif

        <div
            class="relative flex-1"
            x-data="{
                id: 0,
                show: {{ $isInitiallyHidden() ? 'false' : 'true' }},
                isRtl: false,
                generatePasswd: function() {
                    let chars = '{{ $getPasswChars() }}';
                    let password = '';
                    for (let i = 0; i < {{ $getPasswLength() }}; i++) {
                        password += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    $refs.{{ $getXRef() }}.value = password;
                    $wire.set('{{ $getStatePath() }}', password);

                    @if($shouldNotifyOnGenerate())
                        new Notification()
                            .title(@js($getGenerateText()))
                            .seconds(3)
                            .success()
                            .send();
                    @endif
                },
                copyPassword: function() {
                    navigator.clipboard.writeText($refs.{{ $getXRef() }}.value);
                    @if($shouldNotifyOnCopy())
                        new Notification()
                            .title(@js($getCopyText()))
                            .seconds(3)
                            .success()
                            .send();
                    @endif
                },
            }"
             x-init="$nextTick(() => { isRtl = document.documentElement.dir === 'rtl' })"
        >
            <input
                x-ref="{{ $getXRef() }}"
                :type="show ? 'text' : 'password'"
                {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
                dusk="filament.forms.{{ $getStatePath() }}"
                {!! ($autocomplete = $getAutocomplete()) ? "autocomplete=\"{$autocomplete}\"" : null !!}
                {!! $isAutofocused() ? 'autofocus' : null !!}
                {!! $isDisabled() ? 'disabled' : null !!}
                id="{{ $getId() }}"
                {!! filled($value = $getMaxValue()) ? "max=\"{$value}\"" : null !!}
                {!! ($placeholder = $getPlaceholder()) ? "placeholder=\"{$placeholder}\"" : null !!}
                {!! $isRequired() ? 'required' : null !!}
                {{ $getExtraInputAttributeBag()->class([
                    'block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70',
                    'dark:bg-gray-700 dark:text-white' => config('forms.dark_mode'),
                    'border-gray-300' => !$errors->has($getStatePath()),
                    'dark:border-gray-600' => !$errors->has($getStatePath()) && config('forms.dark_mode'),
                    'border-danger-600 ring-danger-600' => $errors->has($getStatePath()),
                    '!pr-8' => $isRevealable() xor $isCopyable() xor $isGeneratable(),
                    '!pr-14' => ($isRevealable() && $isCopyable()) xor ($isRevealable() && $isGeneratable()) xor ($isCopyable() && $isGeneratable()),
                    '!pr-20' => $isRevealable() && $isCopyable() && $isGeneratable(),
                ]) }}
            >
            <div class="absolute inset-y-0 flex items-center mr-1 ml-1 gap-1 pr-2 text-sm leading-5"  x-bind:class="isRtl ? 'left-0' : 'right-0'">

                @if ($isGeneratable())
                    <button
                        type="button"
                        x-on:click.prevent="generatePasswd()"
                    >
                        <x-dynamic-component
                            :component="$getGenerateIcon()"
                            class="h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                        />
                    </button>
                @endif
                @if ($isCopyable())
                    <button
                        type="button"
                        x-on:click.prevent="copyPassword()"
                    >
                        <x-dynamic-component
                            :component="$getCopyIcon()"
                            class="h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                        />
                    </button>
                @endif

                @if ($isRevealable())
                    <button
                        type="button"
                        @click="show = !show"
                        x-bind:class="{ 'block': show, 'hidden': !show }"
                    >
                        <x-dynamic-component
                            :component="$getShowIcon()"
                            class="h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                        />
                    </button>

                    <button
                        type="button"
                        @click="show = !show"
                        x-bind:class="{ 'hidden': show, 'block': !show }"
                    >
                        <x-dynamic-component
                            :component="$getHideIcon()"
                            class="h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                        />
                    </button>
                @endif
            </div>
        </div>

        @if ($label = $getSuffixLabel())
            <span @class($affixLabelClasses)>
                {{ $label }}
            </span>
        @endif

        @if ($icon = $getSuffixIcon())
            <x-dynamic-component
                :component="$icon"
                class="h-5 w-5"
            />
        @endif

        @if (($suffixAction = $getSuffixAction()) && !$suffixAction->isHidden())
            {{ $suffixAction }}
        @endif
    </div>

    @if ($datalistOptions)
        <datalist id="{{ $getId() }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>
