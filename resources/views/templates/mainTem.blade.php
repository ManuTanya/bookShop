<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="http://bookshop/css/main.css" rel="stylesheet">
    <title>Книжный магазин</title>
</head>
<body>
@if(count($errors)>0)
    <div class="error_div">
        <ul>
            @foreach($errors->all() as $er)
            <li>{{$er}}</li>
            @endforeach
        </ul>
    </div>
@endif
<table align="center" class="main_t">
    <tr>
        <td>
            <div class="logo">
                <h1>
                    Книжний магазин
                </h1>
                @yield('menu')
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="content">
                @yield('content')
            </div>
        </td>
    </tr>
</table>
</body>
</html>
