<div style="font-family: Calibri, sans-serif">
    <img src="{{url()}}">
    <br><br>
    <span>
        Kind Regards,<br/>
        <b>Isuzu East Africa</b><br/>
        Mombasa/Enterprise Road<br/>
        P.O Box 30527-00100, Nairobi, Kenya<br/>
        Tel: +254 703 013 222
        <a href="www.isuzutrucks.co.ke">www.isuzutrucks.co.ke</a><br>
        Facebook: Isuzu Kenya
    </span>
</div>
{{--@component('mail::layout')
    --}}{{-- Header --}}{{--
    --}}{{--@slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{$title}}
        @endcomponent
    @endslot--}}{{--




    --}}{{-- Subcopy --}}{{--
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    --}}{{-- Footer --}}{{--
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} Isuzu EA. @lang('All rights reserved.')<br>
            <small>You have received this message because you requested via our *824# USSD code.</small><br/>
            Website: <a href="www.isuzutrucks.co.ke">www.isuzutrucks.co.ke</a> | Facebook: Isuzu Kenya
        @endcomponent
    @endslot
@endcomponent--}}
