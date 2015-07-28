@extends('prof.index')


@section('slider')

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">



    <!-- Indicators -->
    <ol class="carousel-indicators">
        @for($i=0; $i < count($post); $i++)
        <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}" class="active"></li>
        @endfor
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        {{ "";$i=1;}}
        @foreach($post as $value)

        @if($i == 1)
        <div class="item active">
            <center>
                <a href="{{ action('WebsiteController@getPost')}}/{{ $value['id'] }}">
                    <img class="img-responsive" data-src="holder.js/100x180" src="http://www.vpa-uni.com/img{{ $value['img'] }}" alt="...">
                </a>
            </center>
        </div>
        {{ "";$i=null;}}

        @else 
        <div class="item">
            <center>
                <a href="{{ action('WebsiteController@getPost')}}/{{ $value['id'] }}">
                    <img class="img-responsive" data-src="holder.js/100%x180"  src="http://www.vpa-uni.com/img{{ $value['img'] }}" alt="...">
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

@section('content')
<div class='col-md-12 container'>
    <div class='col-md-8'>
        <div class='col-md-offset-1 col-md-10'>
            @yield('slider')
        </div>
        <div class='col-md-2'><br></div>
        <div class='col-md-12'>
            <div class="panel-group" id="accordion">

                @foreach($njoftimet as $value)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse"  href="#news{{ $value['idnjoftimet'] }}">
                                {{ $value['titulli']}}
                            </a> 
                            <span class="badge" >{{ $value['data'] }}</span>
                        </h4>
                    </div>

                    <div id="news{{ $value['idnjoftimet'] }}" class="panel-collapse collapse
                         @if($i <= 2)
                         in
                         {{ "";$i++ }}
                         @endif

                         ">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4 col-md-2">

                                    <a href="#" class="thumbnail">
                                        <img data-src="holder.js/60%x60" src="{{ $destination }}{{$value['avatar']}}" alt="...">
                                    </a>

                                    <span class='badge bg-info' >{{ $value['Autori'] }}</span>
                                </div>
                                {{ $value['msg'] }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class='col-md-4'>
        <div class="table-responsive">
            {{ $template }}
        </div>
        {{ Form::select('genrap',$lactive,current($lactive),array('class'=>'form-control','id'=>'genrap'))}}
        {{ Form::select('vijushmeriaidl',$lactive,current($genrap),array('class'=>'form-control','id'=>'vijushmeria'))}}
        <div id="vijushmeriaresult"></div>
    </div>


</div>

<script>

    $('#genrap').change(function(e) {
        e.preventDefault();
        var dataString = $('#genrap').serialize();
        $.ajax({
            type: "GET",
            url: "{{ action('ProfessorController@getRapnotave') }}",
            data: dataString,
            success: function(data) {
                console.log(data);
                window.location = "{{action('ProfessorController@getRapnotave')}}/?genrap=" + $('#genrap').val();
            }
        },
        "json");
    });

    $('#vijushmeria').change(function(e) {
        e.preventDefault();
        var dataString = $('#vijushmeria').serialize();
        $.ajax({
            type: "GET",
            url: "{{ action('ProfessorController@getPrst') }}",
            data: dataString,
            success: function(data) {
                console.log(data);
                $('#vijushmeriaresult').empty().append(data);
            }
        },
        "json");
    });


</script>
@stop