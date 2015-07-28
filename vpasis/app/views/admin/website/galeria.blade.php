@extends('admin.index')

@section('content')
<div class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Panel title</h3>
        </div>
        <div class="panel-body">
            @foreach($album as $value)
            <div class="col-md-3">
                <img data-src="holder.js/100%x150"  src="/img{{ $value['link'] }}" alt="{{ $value['titulli'] }}" class="img-thumbnail" data-toggle="modal" data-target="#album{{ $value['id'] }}">

                <div class="carousel-control">
                    <a href="{{ action('AdminwebsiteController@getAlbumDelete')}}/{{ $value['id']}}" class=" btn btn-default"><span class="fa fa-trash-o fa-2x"></span></a>

                </div>
                <div class="carousel-caption"  data-toggle="modal" data-target="#album{{ $value['id'] }}">
                    <h3>#{{ $value['numphoto']}}</h3>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="album{{ $value['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">
                                    {{ Form::open(array('url'=>action('AdminwebsiteController@postAlbumUpdate'),'method'=>'POST','class'=>' form-horizontal')) }}
                                    <input type="hidden" name="aid" value="{{$value['id']}}" >
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Album</span>
                                            <input type="text" class="form-control"  name="titulli" value="{{ $value['titulli'] }}">

                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">Ndrysho</button>
                                            </span>
                                        </div>
                                    </div>
                                    {{ Form::close() }} 

                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @foreach($value['photo'] as $val)
                                    <div class="col-md-3">
                                        <img data-src="holder.js/100%x150" src="/img{{ $val['link'] }}" alt="{{ $val['titulli'] }}" class="img-thumbnail" ></img>


                                        <div class="carousel-control">
                                            <a href="{{ action('AdminwebsiteController@getGaleritDelete')}}/{{ $val['id']}}" class=" btn btn-default"><span class="fa fa-trash-o fa-2x"></span></a>

                                        </div>
                                    </div>
                                    @endforeach 
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{ Form::open(array('url'=>action('AdminwebsiteController@postGaleriAdd'),'method'=>'POST','class'=>' form-horizontal','files'=>true)) }}
                                <input type="hidden" name="album" value="{{ $value['id']}}">
                                {{ Form::file('img') }}
                                <button type="submit" class="btn btn-default form-control">{{ Lang::get('general.upload') }}</button>


                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-md-3">
                {{ Form::open(array('url'=>action('AdminwebsiteController@postAlbumAdd'),'method'=>'POST','class'=>' form-horizontal','files'=>true)) }}

                <input type="text" class="form-control"  name="titulli" placeholder="Titulli Albumit">
                <br>
                {{ Form::file('img') }}
                <br><button type="submit" class="btn btn-default form-control">{{ Lang::get('general.upload') }}</button>


                {{ Form::close() }}           
            </div>
        </div>
    </div>
</div>
@stop