@extends('website.index')
@section('navigation')

<ol class="navbread"  >
    {{ $navigation }}
</ol>
@stop
@section('post')
<div class="row">
    <h3 class='bold'>
        <strong>  {{ $post['title_'.Session::get('lang')] }}</strong></h3>
    <h6>{{ Lang::get('general.published') }}{{ $post['published'] }}</h6>
    @yield('navigation')
    <a class="thumbnail">
        <img data-src="holder.js/100%x180" alt="{{ $post['title_'.Session::get('lang')] }}" src='http://www.vpa-uni.com/img{{ $post['img'] }}'>
    </a
    <br>
    <p> 
        {{ $post['description_'.Session::get('lang')] }}
    </p>
    <div class='col-md-offset-1'>&nbsp;</div>
    <div class='hrred'></div><br>
</div>
<br>
<div class="fb-like" data-href="{{action('WebsiteController@getPost')}}/{{ $post['id'] }}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
<div class='row'>&nbsp;</div>   
<div class='row'>&nbsp;</div>

@stop


@section('content')
<div class='col-md-7 col-md-offset-1'>
    @yield('post')
</div>
<div class='col-md-3'>
    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FVPA.University&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=1439318206332515" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
    <div class='row'>&nbsp;</div>
    <br>
    <br>
    <div class="list-group">
        @foreach($listpost as $value)
        @if($post['id'] == $value['id'])
        <a href="{{action('WebsiteController@getPost')}}/{{ $value['id'] }}" class="list-group-item active">
            {{ $value['title_'.Session::get('lang')]  }}
        </a>
        @else
        <a href="{{action('WebsiteController@getPost')}}/{{ $value['id'] }}" class="list-group-item">
            {{ $value['title_'.Session::get('lang')]  }}
        </a>
        @endif
        @endforeach
    </div>
</div>
@stop