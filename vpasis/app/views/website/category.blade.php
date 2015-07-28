@extends('website.index')

@section('category')
<div class="list-group">
    @foreach($postin as $value)
    <div class="col-md-4">
        <a href="{{ action('WebsiteController@getPost') }}/{{ $value['idp'] }}" class="thumbnail">
            <img data-src="holder.js/100%x180" alt="..." src="http://www.vpa-uni.com/img{{ $value['img'] }}"><br>
            <center><span class="h4">{{ $value['titulli'] }}</span></center>
        </a>
    </div>
    @endforeach
</div>
@stop


@section('content')
<br>
<div class="col-md-offset-1 col-md-7">
    <div class='col-md-12'>

        <div class='row'>
            @yield('category')
        </div>
    </div>
</div>
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FVPA.University&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=1439318206332515" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>

@stop