@php
$datalistOptions = $getDatalistOptions();

$sideLabelClasses = ['whitespace-nowrap group-focus-within:text-primary-500', 'text-gray-400' => !$errors->has($getStatePath()), 'text-danger-400' => $errors->has($getStatePath())];
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
        {{ $attributes->merge($getExtraAttributes())->class([
            'flex items-center space-x-1 rtl:space-x-reverse group
                                                        filament-forms-text-input-component',
        ]) }}>
        @if ($label = $getPrefixLabel())
            <span @class($sideLabelClasses)>
                {{ $label }}
            </span>
        @endif


        <div
            class="relative flex-1"
            x-data="{ id: 0, show: false}"
        >
            <input
                x-ref="password"
                :type="show ? 'text' : 'password'"
                {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
                dusk="filament.forms.{{ $getStatePath() }}"
                {!! ($autocomplete = $getAutocomplete()) ? "autocomplete=\" {$autocomplete}\"" : null !!}
                {!! $isAutofocused() ? 'autofocus' : null !!}
                {!! $isDisabled() ? 'disabled' : null !!}
                id="{{ $getId() }}"
                {!! filled($value = $getMaxValue()) ? "max=\" {$value}\"" : null !!}
                {!! ($placeholder = $getPlaceholder()) ? "placeholder=\" {$placeholder}\"" : null !!}
                {!! $isRequired() ? 'required' : null !!}
                {{ $getExtraInputAttributeBag()->class([
                    'block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70',
                    'dark:bg-gray-700 dark:text-white' => config('forms.dark_mode'),
                    'border-gray-300' => !$errors->has($getStatePath()),
                    'dark:border-gray-600' => !$errors->has($getStatePath()) && config('forms.dark_mode'),
                    'border-danger-600 ring-danger-600' => $errors->has($getStatePath()),

                    '!pr-8' => !$isCopyable(),
                    '!pr-14' => $isCopyable(),
                ]) }}
            >
            <div class="absolute inset-y-0 right-0 flex items-center gap-1 pr-2 text-sm leading-5">

                @if($isCopyable())
                    <button type="button"
                            @click="navigator.clipboard.writeText($refs.password.value);$dispatch('notify', {id: 'notification.' + (++id), status: 'primary', message: @js(__('Copied to clipboard'))})"

                    >
                        <x-dynamic-component
                            :component="$getCopyIcon()"
                            class="h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                        />
                    </button>
                @endif

                <button type="button"
                        @click="show = !show"
                        x-bind:class="{ 'block': show, 'hidden': !show }"
                >
                    <x-dynamic-component
                        :component="$getShowIcon()"
                        class="h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                    />
                </button>

                <button type="button"
                        @click="show = !show"
                        x-bind:class="{ 'hidden': show, 'block': !show }"
                >
                    <x-dynamic-component
                        :component="$getHideIcon()"
                        class="h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                    />
                </button>

            </div>
        </div>





        @if ($label = $getPostfixLabel())
            <span @class($sideLabelClasses)>
                {{ $label }}
            </span>
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
