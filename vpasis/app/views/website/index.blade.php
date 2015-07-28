@section('header')
<div class='quicknav col-md-12'>
    <div class="col-md-offset-1 col-md-7 ">
        <ul class="quickmenu">
            @foreach($quickmenu as $value)
            <li><a href="{{ $value['link'] }}">{{ $value['emri'] }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-3 ">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Kerko!</button>
            </span>
        </div>
    </div>
    <div class="col-md-1 "></div>
</div>
<div class="rows">&nbsp; </div>
<div class="col-md-12">
    <div class="col-md-offset-1 col-md-2">
        <a href='{{ action('WebsiteController@getIndex')}}'>
            <img class='img-responsive' data-src="holder.js/100%x180" alt="..." src="http://www.vpa-uni.com/images/logo.png">
        </a>
    </div>
    <div class='col-md-8'><br>
        {{ $category }}
    </div>
</div>
@stop

@section('footer')
<div class="col-md-12 footer-extra">
    <div class="container" style="padding:15px;">
        <div class='col-md-3' style="border-right:1px dotted #fff;">
            <ul class="contfooter">
                <li><h4>Ferizaj</h4></li>
                <li>Rruga "Ahmet Kaçiku" PN</li>
                <li>Ferizaj, Republika e Kosovës 70000</li>
                <li><span class="fa fa-mobile fa-2x"></span> 044 583 573</li>
                <li><span class="fa fa-mobile fa-2x"></span> 0290 326 080</li>
                <li><span class="fa fa-envelope"></span> info@vpa-uni.com</li>
                <li><span class="fa fa-cubes"></span> support@vpa-uni.com</li>
            </ul>
        </div>
        <div class='col-md-3' style="border-right:1px dotted #fff;">
            <ul class="contfooter">
                <li><h4>Prishtine</h4></li>
                <li>Rruga "Eqrem Qabej" PN</li>
                <li>Prishtinë, Republika e Kosovës</li>
                <li><span class="fa fa-mobile fa-2x"></span> 045 690 618</li>
                <li><span class="fa fa-mobile fa-2x"></span> 049 346 035</li>
                <li><span class="fa fa-envelope"></span> info@vpa-uni.com</li>
                <li><span class="fa fa-cubes"></span> support@vpa-uni.com</li>
            </ul>
        </div>
        <div class='col-md-3' style="border-right:1px dotted #fff;">
            <ul class="contfooter">
                <li><a href="/category/10">Bachelor</a></li>
                <li><a href="/post/20">Staffi VPA</a></li>
                <li><a href="/category/15">Aktivitet</a></li>
            </ul>
        </div>
        <div class='col-md-3'>
            <div class="fsocial">
                <ul>
                    <li><a target="_blank" href="https://www.facebook.com/VPA.University"><img width="50" src="http://www.vpa-uni.com/img/facebook.png"></a></li>

                    <li><a target="_blank" href="https://www.youtube.com/channel/UCYn4H0gNnFg2FD5knD3ndlQ"><img width="50" src="http://www.vpa-uni.com/img/youtube.png"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class='col-md-12 container' style='border-top:1px dotted #fff; padding:7px; text-align: center; font-weight:500;'>

        <a href="http://www.vpa-uni.com/" style="color:#B5F1FF;">Kolegji Univeristar VPA</a>: Te gjitha te drejtat e rezervuara VPA (<a style="color:#B5F1FF;" href="mailto:info@vpa-uni.com"> E-mail </a>)

    </div>
</div>
@stop

<html>
    <head>
        <title>{{ $title }}</title>
        <meta name="description" content="{{ htmlspecialchars($descript) }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Universitet, kolegj, programmim, shkenca kompjuterike, ekonomi, menaxhment dhe informatike, teknik, teknologji, projekte, karriera, studime, bachelor">
        {{ HTML::style('style/css/bootstrap.min.css') }}
        {{ HTML::style('style/fonts/awesome/css/font-awesome.min.css') }}
        {{ HTML::style('style/css/bootstrapValidator.min.css') }}
        {{ HTML::style('style/awesome/font-awesome.min.css') }}
        {{ HTML::style('style/css/style.css') }}
        {{ HTML::script('style/js/jquery-1.11.1.min.js') }}
        {{ HTML::script('style/js/bootstrap.min.js') }}
        {{ HTML::script('style/js/bootstrapValidator.min.js') }}
        {{ HTML::script('style/js/jquery.cycle.all.js') }}
        {{ HTML::script('style/js/holder.js') }}
    </head>
    <style>

        body{

            font: 12px/18px sans-serif;
        }
        .category {
            text-align: left;
            display: inline;
            margin: 0;
            padding: 10px 0px 12px 0;
            list-style: none;
            -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
        }
        .category li {
            font: bold 12px/18px sans-serif;
            display: inline-block;
            margin-right: -4px;
            position: relative;
            padding: 10px 15px;
            background: #fff;
            cursor: pointer;
            -webkit-transition: all 0.2s;
            -moz-transition: all 0.2s;
            -ms-transition: all 0.2s;
            -o-transition: all 0.2s;
            transition: all 0.2s;
        }
        .category li:hover a {
            color: #fff;
        }
        .category li a:link{
            color:none;
        }
        .category li ul {
            padding: 0;
            position: absolute;
            z-index: 999;
            top: 38px;
            left: 0;
            width: 250px;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            display: none;
            opacity: 0;
            visibility: hidden;
            -webkit-transiton: opacity 0.2s;
            -moz-transition: opacity 0.2s;
            -ms-transition: opacity 0.2s;
            -o-transition: opacity 0.2s;
            -transition: opacity 0.2s;
        }
        .category li ul li { 
            background: #003478; 
            display: block; 
            color: #fff;
        }
        .category li ul li a{
            font-weight: none;
            color:#fff;
        }
        .category li ul li:hover a{
            color:#003478;
        }
        .category li ul li:hover { background: #eee; }
        .category li:hover ul {
            display: block;
            opacity: 1;
            visibility: visible;
        }
        .menu-header li a{
            color:#fff;
        }
        .quicknav{
            background:#003478;
            height:auto;
            display:block;
            padding: 6px 0 4px 0;
        }
        .quickmenu {
            margin-top: 2px;
        }
        .quickmenu li{
            display:inline;
            padding:  0 10px 0 10px;
        }
        .quickmenu li a{
            color:#fff;
        }
        .category li a{
            color:#000;
            font-size:1.2em;
            padding:3px;
            font-weight: Bold;
            text-transform: uppercase;
        }
        .category li a:hover{
            color:#fff;
            text-decoration: none;
        }
        .category li:hover{
            background: #003478;
        }
        .navbread{
            padding: 5px;
            background:#c3c3c3;
        }
        .navbread li a{
            color:#555555;
            font-weight: Bold;
        }
        .navbread li{
            display: inline;
            padding:2px 10px 2px 10px;
        }
        .navbreadactive{
            background: #003478;
            color:#fff;
        }
        .footer-extra{
            background: #003478;
            color:#fff;
        }
        .fsocial li{
            display: inline;
        }
        .contfooter li{
            list-style: none;
        }
        .contfooter li a{
            color:#fff;
        }
        .hrred{
            border-bottom:2px solid red;
        }
        .pics {  
            height:  232px;  
            width:   232px;  
            padding: 0;  
            margin:  0;  
        } 

        .pics img {  
            padding: 15px;  
            border:  1px solid #ccc;  
            background-color: #eee;  
            width:  200px; 
            height: 200px; 
            top:  0; 
            left: 0 
        } 
    </style>
    <body><div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1439318206332515&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        @yield('header')
        <div class='col-md-12'>&nbsp;</div>
        <div class="col-md-12">
            @yield('content')
        </div>
        @yield('footer')
    </body>
</html>