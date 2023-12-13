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
    $initiallyHidden = $isInitiallyHidden() ? 'true' : 'false';

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

    $xdata = '{ show: ' . $initiallyHidden . ',
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
             {{svg($getShowIcon(), "w-5 h-5")}}
        </button>
        <button type="button" class="flex hidden inset-y-0 right-0 items-center p-1 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200" @click="show = !show" :class="{'block': !show, 'hidden': show }">
              {{svg($getHideIcon(), "w-5 h-5")}}
        </button>
        @endif
         @if ($isGeneratable())
                    <button
                        type="button"
                        x-on:click.prevent="generatePasswd()"
                        class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 p-1"
                    >
                       {{svg($getGenerateIcon(), "w-5 h-5")}}

                    </button>
                @endif

                @if ($isCopyable())
                    <button
                        type="button"
                        x-on:click.prevent="copyPassword()"
                        class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 p-1"
                    >
                      {{svg($getCopyIcon(), "w-5 h-5")}}

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
