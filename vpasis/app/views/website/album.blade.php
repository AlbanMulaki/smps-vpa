@extends('website.index')

@section('content')

<div class='col-md-7 col-md-offset-1'>


    <div class="list-group">
        @foreach($album as $value)
        <div class="col-md-4">
            <a href="{{ action('WebsiteController@getGaleria') }}/{{ $value['id'] }}" class="thumbnail">
                <img data-src="holder.js/100%x180" alt="..." src="http://www.vpa-uni.com/img{{ $value['link'] }}"><br>
                <center><span class="h4">{{ $value['titulli'] }}</span></center>
            </a>
        </div>
        @endforeach
    </div>

</div>
<div class='col-md-3'>
    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FVPA.University&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=1439318206332515" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
    <div class='row'>&nbsp;</div>
</div>

@stop