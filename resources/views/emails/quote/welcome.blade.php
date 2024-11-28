<div style="font-family: Calibri, sans-serif">
    Dear {{$name}}<br><br>
    Thank you for showing interest in the ISUZU {{ $model->new_model_name_customer }}.<br><br>
    Herein attached is a copy of <strong>ISUZU {{ $model->new_model_name_customer }}</strong> quote for your review.<br><br>
    We look forward to doing business with you.<br><br>
    <h4>Description</h4>
    {!! $model->description !!}
    <br>
    @if($signature)
        <span>
            Regards,<br><br>
            ISUZU East Africa<br>
            Mombasa/Enterprise Road<br>
            PO Box 30527-00100, Nairobi, Kenya<br>
            T:+254 703 013 222<br>
            Website: <a href="www.isuzu.co.ke">www.isuzu.co.ke</a><br>
            <span>
                <img src="http://35.228.82.108/gmea/public/images/fb.png" style="width: 20px;height: auto"> IsuzuKenya
                <img src="http://35.228.82.108/gmea/public/images/twitter.png" style="width: 20px;height: auto">
                IsuzuKenya
            </span><br>
{{--            <img src="http://35.228.82.108/gmea/public/images/footer_2.jpg" style="max-width: 624px;height: auto">--}}
        </span>
    @endif
</div>
