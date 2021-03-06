@extends('website.index')

@section('content')

<div class='col-md-7 col-md-offset-1'>
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach($album as $value)
            @if($i == 0)
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            @else
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            @endif
            {{ "";$i++}}
            @endforeach
            {{ "";$i=0}}
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            @foreach($album as $value)
            @if($i == 0)
            <div class="item active">
                <img alt="..." src="http://www.vpa-uni.com/img{{ $value['link'] }}">
                <div class="carousel-caption">
                    {{ $value['titulli'] }}
                </div>
            </div>
            @else
            <div class="item">
                <img alt="..." src="http://www.vpa-uni.com/img{{ $value['link'] }}">
                <div class="carousel-caption">
                    {{ $value['titulli'] }}
                </div>
            </div>
            @endif
            {{ "";$i++}}
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

</div>
<div class='col-md-3'>
    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FVPA.University&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=1439318206332515" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
    <div class='row'>&nbsp;</div>
</div>

<div class="col-md-12"><br><br></div>
@stop