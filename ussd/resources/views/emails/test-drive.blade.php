@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{$title}}
        @endcomponent
    @endslot

    {!! $body !!}
    <br><br>
    <small>
        Kind Regards,<br/><br/>
        <b>Isuzu East Africa</b><br/>
        Mombasa/Enterprise Road<br/>
        P.O Box 30527-00100, Nairobi, Kenya<br/>
        Tel: +254 703 013 222
    </small>

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} Isuzu EA. @lang('All rights reserved.')<br>
            <small>You have received this message because you requested via our *824# USSD code.</small><br/>
            Website: www.isuzutrucks.co.ke | Facebook: Isuzu Kenya
        @endcomponent
    @endslot
@endcomponent
