<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .column {
        float: left;
        width: auto;
        padding: 10px;
        
        }

        /* Clear floats after the columns */
        .row:after {
        content: "";
        display: table;
        clear: both;
        }
    </style>

</head>
<body>
    
    <h1 style="color: green">QRCODE</h1>

    <br>
    @php
        $loop=true;
        $n=0;
        $tmpBarcode=intVal($currentBarcode);
    @endphp
    <table>
        @while ($loop==true) 
            <tr>
                @for ($i = 0; $i < 8; $i++)
                    <td>
                        <div style="margin: 7px">
                            
                           
                            <div style="width: 100%;text-align: center; font-size: 12px;">
                                <div style=" display: flex;justify-content: center;">
                                    @php
                                        $tmpBarcode+=1;
                                        $n +=1;
                                        echo DNS2D::getBarcodeHTML($nameBarcode.$tmpBarcode, 'QRCODE',3,3);   
                                    @endphp
                                </div>
                                {{ $nameBarcode.$tmpBarcode}} 
                            </div>
                            @if ($tmpBarcode == (intVal($currentBarcode)+$count))
                                @php
                                    $loop=false;
                                @endphp
                                @break
                            @endif
                        </div>
                        

                    </td>
                @endfor 
            </tr>
                  
            
            @if ($n==$count)
                @php
                    $loop=false;
                @endphp
            @endif
        @endwhile

    </table>

    
</body>
</html>