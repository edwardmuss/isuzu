<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotation</title>

    <style type="text/css">
        @font-face {
            font-family: 'Titillium Web';
            src: url({{ storage_path('fonts\TitilliumWeb-Light.ttf') }}) format("truetype");
            font-weight: 100;
            font-style: normal;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
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
    <style>
        .elm-pad {
            padding-top: 20px !important;
        }
    </style>

</head>
<body>
<footer>
    <p style="font-size: 10px">System generated Quotation</p>
</footer>
<table width="100%" style="margin-bottom: 5px;padding-bottom: 0px;">
    <tr>
        <td valign="top" style="margin-bottom: 0px;padding-bottom: 0px"><img
                src="{{ base_path("public/images/Isuzu_Logo.png") }}" alt="" width="120"/></td>
        <td align="right" style="margin-bottom: 0px;padding-bottom: 0px;color: red;font-weight: bolder">
            PROFORMA INVOICE
            <pre
                style="font-family: 'Titillium Web', sans-serif;font-weight: 100;margin: 5px;padding: 0px;color: black;font-size: 11px">
            QUOTE NO. <span class="elm-pad"
                            style="margin: 10px;border: 1px solid red;color: red;padding: 10px;font-size: 16px">S{{$proforma}}</span>
            </pre>
            {{--
                        <h6 style="color: red">PROFORMA QINVOICE</h6>
            --}}
        </td>
    </tr>
</table>
{{--<table width="100%">
    <tr>
        <td width="50%" style="font-size: 9px;line-height: 1.6">
            <br>
            ISUZU EAST AFRICA LIMITED<br>
            ENTERPRICE/MOMBASA ROAD<br>
            P.O BOX 30527-00100<br>
            NAIROBI, KENYA<br>
            MOBILE: 0720636589<br>
            EMAIL:<br><br><br>
    </tr>
</table>--}}
<br>
<br>
<br>
<table width="100%" cellspacing="0px" style="border-collapse: collapse;margin-bottom: 10px">
    <thead style="">
    <tr style="font-size: 11px;">
        <td style="border-bottom: 1px grey solid; border-top: 1px grey solid">QUOTATION DATE</td>
        <td style="border-bottom: 1px grey solid; border-top: 1px grey solid" align="center">QUOTATION VALIDITY</td>
        <td style="border-bottom: 1px grey solid; border-top: 1px grey solid" align="right">QUOTATION EXPIRY</td>
    </tr>
    </thead>
    <tbody style="margin-top: 5px;font-size: 10px">
    <tr>
        <td style="font-weight: bold">{{\Carbon\Carbon::now()->format('d M, Y H:i:s')}}</td>
        <td style="font-weight: bold" align="center">14 DAYS</td>
        <td style="font-weight: bold" align="right">{{\Carbon\Carbon::now()->addDays(14)->format('d M, Y H:i:s')}}</td>
    </tr>
    </tbody>
</table>
<table width="100%" style="margin-bottom: 10px;font-size: 10px;font-family: 'Titillium Web', sans-serif;font-weight: 100;">
    <tr>
        <td style="line-height: 1.6">
            <span style="color: red;font-size: 11px;font-weight: 500;">
                <br>
                <b>CUSTOMER</b>
            </span><br>
            {{$name}}<br>
            {{$phone}}<br>
            {{$email}}<br><br>
        </td>
        </td>
    </tr>
</table>
@include('emails.quote._quotations_v2')

<br>
<br>
<table width="100%">
    <tr>
        <td style="font-size:9pt;color: red"><b>TERMS AND CONDITIONS</b></td>
    </tr>
</table>
<table width="100%" style="font-family: 'Titillium Web', sans-serif;font-size: 10px">
    <tr>
        <td>1. VEHICLE DELIVERY IS SUBJECT TO AVAILABILITY OF STOCKS  EX-ISUZU FACTORY AT TIME OF ORDERING</td>
    </tr>
    <tr>
        <td>2. ISUZU RESERVES THE RIGHT TO CHANGE PRICES AND/OR SPECIFICATIONS WITHOUT PRIOR NOTICE</td>
    </tr>
    <tr>
        <td>3. THIS QUOTATION IS VALID FOR <strong>14 DAYS</strong></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
</table>
<table width="100%" style="margin-top: 20px;font-size: 10px;font-family: 'Titillium Web', sans-serif">
    <tr>
        <td style="font-size:9pt"><b>For more information, kindly contact any of the Isuzu dealers nearest to you;</b>
        </td>
    </tr>
</table>
<table width="100%" style="font-size: 10px;font-family: 'Titillium Web', sans-serif">
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
    <tr style="height: 25px">
        <td width="50px">
        </td>
        <td style="color: red;font-size: 13px">
            <br>
            <strong>Isuzu Toll Free Number: 0 800 724 724</strong>
        </td>
    </tr>
</table>
</body>
</html>
