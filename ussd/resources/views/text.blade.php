<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotation</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
        .page-break {
            page-break-after: always;
        }
        @page {
            margin-bottom: 50px
        }
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            text-align: center;
            height: 65px;
        }
        p {
            page-break-after: always;
        }
        p:last-child {
            page-break-after: never;
        }
    </style>

</head>
<body>
{{--<footer>
    <hr>
    <h6>Isuzu. 2019. Head office : Enterprise Road, off Mombasa Road | P.O. Box 30527 Nairobi GPO, 00100 Kenya</h6>
</footer>--}}
<table width="100%">
    <tr>
        <td valign="top"><img src="{{ base_path("public/images/logo.jpg") }}" alt="" width="150"/></td>
        <td align="right">
            {{-- <h3>Isuzu East Africa</h3>
             <pre>
             Tel: 0800 724 724
             Mail: info.kenya@isuzu.co.ke
             Pin:--}}
            </pre>
        </td>
    </tr>

</table>

<div style="border: 1px grey solid">
    <table width="100%">
        <tr>
            <td width="60%">
                <strong>To</strong><br>
                <strong>Name: </strong> {{$name}}<br>
                <strong>Tel No: </strong> {{$phone}}<br>
                <strong>Email: </strong> {{$email}}
            </td>
            <td align="right">
                <strong>Proforma No.</strong>{{$proforma}}<br>
                <strong>Date Issued.</strong>{{\Carbon\Carbon::now()->toDateTimeString()}}
            </td>
        </tr>
    </table>
    @include('_includes._quotations')
    <hr>
    <table width="100%">
        <tr>
            <td style="font-size:9pt"><b>Terms and Conditions;</b></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>1. Vehicle delivery is subject to availability of stocks Ex-Warehouse at time of ordering</td>
        </tr>
        <tr>
            <td>2. Isuzu reserves the right to change prices and/or specifications without prior notice</td>
        </tr>
        <tr>
            <td>3. This quotation is valid for 14 days</td>
        </tr>
    </table>
</div>
<div style="border: 1px solid gray;margin-top: 10px">
    <table width="100%">
        <tr>
            <td style="font-size:9pt"><b>For more information, kindly contact any of the Isuzu dealers nearest to you;</b></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50px">
                <img src="{{ base_path("public/images/am_logo.png") }}" alt="" width="50"/>
            </td>
            <td><b>Associated Motors Limited</b>,<br>Nairobi:0723 650650, Mombasa: 0724 583555, Meru: 0724 780555, Eldoret: 0706759205
            </td>
        </tr>
        <tr>
            <td width="50px">
                <img src="{{ base_path("public/images/acmg_logo.png") }}" alt="" width="50"/>
            </td>
            <td><b>Africa Commercial Motors Group Ltd</b>,<br>Nakuru: 0736 928928, Kisumu: 0733 636183, Kisii: 0780 600801, Kericho: 0788 320932
            </td>
        </tr>
        <tr>
            <td width="50px">
                <img src="{{ base_path("public/images/cfg_logo.png") }}" alt="" width="50"/>
            </td>
            <td><b>Central Farmers Garage</b>,<br>Kitale Tel: 054-31335, Nairobi Tel: 020 3522435, Lodwar Tel: 0726 282001
            </td>
        </tr>
        <tr>
            <td width="50px">
                <img src="{{ base_path("public/images/kci_logo.png") }}" alt="" width="50"/>
            </td>
            <td><b>Kenya Coach Industries</b>,<br>Nairobi Tel: 0722 237231</td>
        </tr>
        <tr>
            <td width="50px">
                <img src="{{ base_path("public/images/ryce_logo.png") }}" alt="" width="50"/>
            </td>
            <td><b>Ryce East Africa Ltd</b>,<br>Nairobi Tel: 0724 256665, Mombasa Tel: 0732 777266</td>
        </tr>
        <tr>
            <td width="50px">
                <img src="{{ base_path("public/images/tmd_logo.png") }}" alt="" width="50"/>
            </td>
            <td>
                <b>Thika Motor Dealers</b>,<br>Thika: 0714076001, Machakos: 0726 605550, Ruaka: 0701 193330, Karatina: 0714 074001,
                Athi River: 0706450050
            </td>
        </tr>
        <tr>
            <td width="50px">
            </td>
            <td style="color: red">
                Isuzu Contact Center No. 0 800 724 724
            </td>
        </tr>
    </table>
</div>
</body>
</html>
