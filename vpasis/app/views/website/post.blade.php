@extends('website.index')


@section('slider')
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">



    <!-- Indicators -->
    <ol class="carousel-indicators">
        @for($i=0; $i < count($slide); $i++)
        <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}" class="active"></li>
        @endfor
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        {{ "";$i=1;}}
        @foreach($slide as $value)

        @if($i == 1)
        <div class="item active">
            <center>
                <a href="{{ action('WebsiteController@getPost')}}/{{ $value['id'] }}">
                    <img class="img-responsive" style="
                         max-height: 300px;"  data-src="/style/js/holder.js/100%x300" src="http://www.vpa-uni.com/img{{ $value['img'] }}" alt="...">
                </a>
            </center>
        </div>
        {{ "";$i=null;}}

        @else 
        <div class="item">
            <center>
                <a href="{{ action('WebsiteController@getPost')}}/{{ $value['id'] }}">
                    <img class="img-responsive img-rounded" style="
                         max-height: 300px;" data-src="/style/js/holder.js/100%x300"  src="http://www.vpa-uni.com/img{{ $value['img'] }}" alt="...">
                </a>
            </center>
        </div>
        @endif
        @endforeach
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
@stop


@section('navigation')

<ol class="navbread"  >
    <li class="navbreadactive">{{ Lang::get('website.home') }}</li>
</ol>
@stop

@section('listpost')
@for($i=0;$i < count($latest_post);$i++)
@if($i == 0)
<div class='row'>
    @endif
    <div class='col-md-4'>
        <div class="thumbnail">
            <div class='' style='border-bottom:#cc2200 2px solid;'>
                <h6> {{ $latest_post[$i]['emri'] }}</h6>
            </div>
            <img data-src="holder.js/300x300" alt="..." src='http://www.vpa-uni.com/img{{ $latest_post[$i]['img'] }}'>
            <div class="caption">
                <h4>{{ $latest_post[$i]['titulli'] }}</h4>
                <p>{{ substr($latest_post[$i]['msg'], 0, 100) }}</p>
                <p><a href="{{ action('WebsiteController@getPost').'/'.$latest_post[$i]['id'] }}" class="btn btn-primary" role="button">Lexo</a> </p>
            </div>
        </div>
    </div>  
    @if($i == 2)

</div>
<div class="row">
    @endif    @if($i == 5)
</div>
@endif
@endfor
@stop

@section('content')
<br>
<div class="col-md-offset-1 col-md-7">
    <div class='col-md-12'>

        <div class='row'>
            @yield('slider')
        </div><br>
        <div class='row'>
            @yield('navigation')
        </div>
        <div class='row'>
            @yield('listpost')
        </div>
    </div>
</div><div class="col-md-3">
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FVPA.University&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=1439318206332515" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>

<script src="https://apis.google.com/js/platform.js"></script>

<div class="g-ytsubscribe" data-channelid="UCYn4H0gNnFg2FD5knD3ndlQ" data-layout="full" data-count="default"></div>

    <br>
    <div class="pics" id="shuffle"> 

        @for($i=0;$i < count($latest_post);$i++)
        <div class="well ">
            <h4>{{ $latest_post[$i]['titulli'] }}</h4>
            <span class="h6">{{ substr( str_replace("<h3>"," ",str_replace('</h3>',"", $latest_post[$i]['msg'])), 0, 250)}}<br>
                <a href="{{ action('WebsiteController@getPost').'/'.$latest_post[$i]['id'] }}" class="btn btn-sm btn-warning" role="button">Lexo</a> 
            </span>
        </div>
        </img>
        @endfor

    </div> 

</div>
<script>

$('#shuffle').cycle('fade');
</script>




@stop