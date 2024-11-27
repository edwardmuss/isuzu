<table width="100%" cellspacing="0px" style="border-collapse: collapse;font-family: 'Titillium Web', sans-serif">
    <thead style="font-size: 11px;background-color: #efefef;color: red;border-bottom: 1px grey solid;border-top: 1px grey solid">
    <tr>
        <th>ITEM</th>
        <th style="border-bottom: 1px solid #656565;border-top: 1px solid 656565" align="center">IMAGE</th>
        <th align="left">PRODUCT</th>
        <th align="center">QTY</th>
        <th align="center">PRICE</th>
        <th align="center">DISCOUNT</th>
        <th align="center">AMOUNT</th>
        <th align="right">TOTAL</th>
    </tr>
    </thead>
    <tbody style="margin-top: 15px;font-size: 11px">
    <tr>
        <td align="left">1</td>
        <td align="center">
            <img src="{{ base_path("public/new_images/".$image) }}" alt="" width="150" style="margin-top: 20px"/>
        </td>
        <td align="left">{!! $details !!}</td>
        <td align="center">1</td>
        <td align="center">{{number_format($model->original_value, 2, ".", ",")}}</td>
        <td align="center">{{number_format(($model->original_value - $model->value), 2, ".", ",")}}</td>
        <td align="center">{{number_format($model->value, 2, ".", ",")}}</td>
        <td align="right"><strong>{{number_format($model->value, 2, ".", ",")}}</strong></td>
    </tr>
    </tbody>
</table>
<table width="100%" style="font-size: 11px">
    <tbody>
    {{--<tr>
        <td colspan="3"></td>
        <td align="right">Subtotal</td>
        <td align="right">
            KES: {{number_format((($price/1.16)), 2, ".", ",")}}
        </td>
    </tr>--}}
    <tr>
        <td colspan="8" style="border-bottom: 1px solid grey;"></td>
    </tr>
    <tr style="font-family: 'Titillium Web', sans-serif;font-size: 10px">
        <td colspan="6"></td>
        <td align="right">BODY PRICE</td>
        <td align="right">0</td>
    </tr>
    <tr style="font-family: 'Titillium Web', sans-serif;font-size: 10px">
        <td colspan="6"></td>
        <td align="right">KRA ADV TAX</td>
        <td align="right">0</td>
    </tr>
    <tr style="font-family: 'Titillium Web', sans-serif;font-size: 10px">
        <td colspan="6"></td>
        <td align="right">REG_INSP FEE</td>
        <td align="right">0</td>
    </tr>
    <tr style="font-family: 'Titillium Web', sans-serif;font-size: 10px">
        <td colspan="6"></td>
        <td align="right">OTHER COSTS</td>
        <td align="right">0</td>
    </tr>
    <tr>
        <td colspan="8" style="border-bottom: 1px solid grey;"></td>
    </tr>
    {{--<tr style="color: red;font-family: 'Titillium Web', sans-serif">
        <td style="border-bottom: 1px solid red" colspan="3"></td>
        <td style="border-bottom: 1px solid red" align="right"></td>
        <td style="border-bottom: 1px solid red" align="right">
            VAT (14%): KES {{number_format((($price/1.14)*0.16), 2, ".", ",")}}
        </td>
    </tr>--}}
    </tbody>
</table>
<table width="100%">
    <tbody>
    <tr style="color: red;font-family: 'Titillium Web', sans-serif">
        <td colspan="3"></td>
        <td align="right"></td>
        <td align="right" style="color: red;font-family:'Titillium Web', sans-serif;font-size: 13px">
            TOTAL AMOUNT <strong>(PRICES ARE DUTY AND VAT INCLUSIVE)</strong>:
                <span class="elm-pad" style="padding: 10px;border: 1px solid red;color: red;font-size: 16px">
                    KES: {{number_format((float)$model->value, 2, ".", ",")}}
                </span>
        </td>
    </tr>
    </tbody>
</table>

