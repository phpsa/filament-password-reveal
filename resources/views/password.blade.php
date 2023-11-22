@php
    $datalistOptions = $getDatalistOptions();
    $extraAlpineAttributes = $getExtraAlpineAttributes();
    $id = $getId();
    $isConcealed = $isConcealed();
    $isDisabled = $isDisabled();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $mask = $getMask();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();

$stylecode = '';
    $x = 0;
    if ($isRevealable() || $isGeneratable() || $isCopyable())
     {
        $x += $isRevealable() ? 2 : 0;
        $x += $isGeneratable() ? 2 : 0;
        $x += $isCopyable() ? 2 : 0;
        $stylecode = 'isRtl ? \'padding-left: '.$x.'rem\' : \'padding-right: '.$x.'rem\'';
     }

    $generatePassword = '
                    let chars = \''. $getPasswChars().'\';
                    let minLen = '. $getPasswLength(). ';


                    let password = [];
                    while(password.length <= minLen){
                        password.push(chars.charAt(Math.floor(Math.random() * 26)));
                        password.push(chars.charAt(Math.floor(Math.random() * 26) +26));
                        if(chars.length > 52 && password.length > 4){
                            password.push(chars.charAt(Math.floor(Math.random() * 10) +52));
                        }
                        if(chars.length > 62 && password.length > 4){
                            password.push(chars.charAt(Math.floor(Math.random() * 10) +62));
                        }
                    }
                    password = password.slice(0, minLen).sort(() => Math.random() - 0.5).join(\'\')

                    $wire.set(\'' . $getStatePath() . '\', password);
                ';
        if($shouldNotifyOnGenerate()){
            $generatePassword .= 'new FilamentNotification()
                            .title(\'' . $getGenerateText() . '\')
                            .seconds(3)
                            .success()
                            .send();';
        }

    $copyPassword = ' copyPassword: function() {
                    navigator.clipboard.writeText( $wire.get(\'' . $getStatePath() . '\'));
                    ';
                    if($shouldNotifyOnCopy() || true) {
                       $copyPassword .= "new FilamentNotification()
                            .title('" . $getCopyText() . "')
                            .seconds(3)
                            .success()
                            .send();";
                    }
                $copyPassword .= '}';

    $xdata = '{ show: true,
            isRtl: false,
            generatePasswd: function() {

                ' . $generatePassword . '
                },
                ' . $copyPassword . '
                }';
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :valid="! $errors->has($statePath)"
        class="fi-fo-text-input"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class(['overflow-hidden relative'])
        "
        x-data="{{ $xdata }}"
    >
        <x-filament::input
            :attributes="
                \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                    ->merge($extraAlpineAttributes, escape: false)
                    ->merge([
                        'autocapitalize' => $getAutocapitalize(),
                        'autocomplete' => $getAutocomplete(),
                        'autofocus' => $isAutofocused(),
                        'disabled' => $isDisabled,
                        'id' => $id,
                        'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        'inlineSuffix' => true,
                        'inputmode' => $getInputMode(),
                        'list' => $datalistOptions ? $id . '-list' : null,
                        'max' => (! $isConcealed) ? $getMaxValue() : null,
                        'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                        'min' => (! $isConcealed) ? $getMinValue() : null,
                        'minlength' => (! $isConcealed) ? $getMinLength() : null,
                        'placeholder' => $getPlaceholder(),
                        'readonly' => $isReadOnly(),
                        'required' => $isRequired() && (! $isConcealed),
                        'step' => $getStep(),
                        ':type' => 'show ? \'password\' : \'text\'',
                        ':style' => $stylecode,
                        $applyStateBindingModifiers('wire:model') => $statePath,
                        'x-data' => (count($extraAlpineAttributes) || filled($mask)) ? '{}' : null,
                        'x-mask' . ($mask instanceof \Filament\Support\RawJs ? ':dynamic' : '') => filled($mask) ? $mask : null,
                    ], escape: false)

            "
             x-init="$nextTick(() => { isRtl = document.documentElement.dir === 'rtl' })"
             x-ref="{{ $getXRef() }}"

        />

        @if ($isRevealable() || $isGeneratable() || $isCopyable())

<div
            @class([
                'flex items-center gap-x-1 pe-1',
                'ps-1',
                'border-s border-gray-200 ps-1 dark:border-white/10',
                'absolute top-0  height-100'
            ])
            :style="isRtl ? 'left:0;height:100%' : 'right:0;height:100%'"
        >
        @if ($isRevealable())
        <button type="button" class="flex hidden inset-y-0 right-0 justify-self-end items-center p-1 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200" @click="show = !show" :class="{'hidden': !show, 'block': show }">
            <!-- Heroicon name: eye -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>
        <button type="button" class="flex hidden inset-y-0 right-0 items-center p-1 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200" @click="show = !show" :class="{'block': !show, 'hidden': show }">
            <!-- Heroicon name: eye-slash -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
        </button>
        @endif
         @if ($isGeneratable())
                    <button
                        type="button"
                        x-on:click.prevent="generatePasswd()"
                        class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 p-1"
                    >
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
</svg>

                    </button>
                @endif

                @if ($isCopyable())
                    <button
                        type="button"
                        x-on:click.prevent="copyPassword()"
                        class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 p-1"
                    >
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
</svg>

                    </button>
                @endif
</div>
                @endif

    </x-filament::input.wrapper>

    @if ($datalistOptions)
        <datalist id="{{ $id }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>
