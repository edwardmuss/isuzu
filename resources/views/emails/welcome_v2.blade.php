<div id="bodyWelcome">
    {!! $body !!}

    <br><br>
    @if($signature)
        <span>
            Regards,<br><br>
            Isuzu East Africa<br>
            Mombasa/Enterprise Road<br>
            PO Box 30527-00100, Nairobi, Kenya<br>
            T:+254 703 013 222<br>
            Website: <a href="www.isuzu.co.ke">www.isuzu.co.ke</a><br>
            <span>
                <img src="{{ asset('images/fb.png') }}" style="width: 20px;height: auto"> IsuzuKenya
                <img src="{{ asset('images/twitter.png') }}" style="width: 20px;height: auto">
                IsuzuKenya
            </span><br>
            <img src="{{ asset('images/isuzu_footer.jpg') }}" style="max-width: 624px;height: auto">
        </span>
    @endif
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

<style>
    @font-face {
        font-family: 'Century Old';
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        src: local(''),
        url('../../../fonts/century.otf') format('otf'), /* Chrome 26+, Opera 23+, Firefox 39+ */
    }

    #bodyWelcome{
        font-family: 'Century Old';
    }
</style>
