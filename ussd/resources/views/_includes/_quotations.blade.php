<hr>
<strong>Items</strong>
<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th align="center">SI No.</th>
        <th align="center">Details</th>
        <th align="center">Quantity</th>
        <th align="right">Total Amount</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="center">1</td>
        <td align="center">{{$details}}</td>
        <td align="center">1</td>
        <td align="right">{{number_format((($price/1.16)), 2, ".", ",")}}</td>
    </tr>
    </tbody>
</table>
<img src="{{ base_path("public/images/".$image) }}" alt="" width="300" style="margin-top: 20px"/>
<table width="100%">
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td align="right">Subtotal</td>
        <td align="right">
            KES: {{number_format((($price/1.16)), 2, ".", ",")}}
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td align="right">Tax (16%)</td>
        <td align="right">
            KES: {{number_format((($price/1.16)*0.16), 2, ".", ",")}}
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td align="right">Discount</td>
        <td align="right">KES: 0</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td align="right">Total</td>
        <td align="right">KES: {{number_format((float)$price, 2, ".", ",")}}</td>
    </tr>
    </tfoot>
</table>
