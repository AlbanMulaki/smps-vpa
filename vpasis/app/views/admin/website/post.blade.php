@extends('admin.index')
@section('createpost')
<!--start Modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    +
</button>
{{ Form::open(array('url'=>action('AdminwebsiteController@postAddpost'),'method'=>'POST','class'=>' form-horizontal','files'=>true)) }}

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Post</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="input-group">
                        <span class="input-group-addon">Titulli</span>                            
                        <input type="text" class="form-control" name='titulli'>
                    </div>
                    <br>                        
                    <textarea class="form-control"  rows='12' name='msg'></textarea>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon">Category</span>
                        {{ Form::select('cat',$cat,current($cat),array('class'=>'form-control')); }}

                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-2">
                            <label>Slider:</label>
                        </div>
                        <div class="col-md-2">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="slide"   value="0">
                                    {{ Lang::get('website.no') }}
                                </label>   
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" name="slide" value="1">

                                    {{ Lang::get('website.yes') }}
                                </label>   
                            </div>
                        </div>  

                    </div>

                    {{ Form::file('img') }}



                </form>
            </div>
            <div class="modal-footer">
                <center><button type="submit" class="btn btn-primary">{{ Lang::get('website.post')}}</button></center>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}

</div>
<!--end Modal -->
@stop



@section('content')
<div class="container">
    @yield('createpost')
    <!--start table -->
    <div class="container">
        {{ Session::get('notification') }}
        <div class="table-responsive">
            <table class="table">
                <thead>
                <th>#</th>
                <th>Titulli</th>
                <th>Kategoria</th>
                <th>Post</th>
                <th>Slider</th>
                <th>Edit</th>
                <th>Delete</th>
                </thead>
                @foreach($post as $value)

                <tr>
                    <td>{{ $value['idpost'] }}</td>
                    <td>{{ $value['titulli'] }}</td>
                    <td>{{ $value['kategoria'] }}</td>
                    <td>{{ $value['postuesi'] }}</td>
                    @if($value['slide'] == 0)
                    <td><span class="fa fa-circle" style="color:#D9534F;"></span></td>
                    @else

                    <td><span class="fa fa-circle" style="color:#5CB85C;"></span></td>
                    @endif
                    <td><a href="#" data-toggle="modal" data-target="#editpost{{ $value['idpost'] }}" class="btn-sm btn-default active"> <span class="fa fa-pencil-square-o"></span></a></td>
                    <td><a href="#" data-toggle="modal" data-target="#delpost{{ $value['idpost'] }}" class="btn-sm btn-default active"> <span class="fa fa-trash-o"></span></a></td>
                    <!-- Edit Modal -->
                <div class="modal fade" id="editpost{{ $value['idpost'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Post</h4>
                            </div>
                            {{ Form::open(array('url'=>action('AdminwebsiteController@postPedit'),'method'=>'POST','class'=>' form-horizontal','id'=>'form1searchcompose','role'=>'search','name'=>'form1searchcompose','files'=>true)) }}

                            <div class="modal-body">



                                <input type='hidden' name='idp'  value='{{$value['idpost']}}'>
                                {{ Form::file('img') }}
                                {{ HTML::image("img/".$value['img'],null,['class'=>'img-thumbnail','data-src='=>'holder.js/100%x180']) }}

                                <input type="text" class="form-control" name='titulli' value='{{ $value['titulli'] }}'>

                                <br>              
                                <textarea name='msg' rows='12' class='form-control' required>{{ $value['post'] }} </textarea>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">{{ Lang::get('website.category') }}</span>
                                    {{ Form::select('cat',$cat,$value['catid'],array('class'=>'form-control')); }}
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Slider:</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="slide"  value="0" @if($value['slide'] == 0) checked @endif >
                                                       {{ Lang::get('website.no') }}
                                            </label>   
                                        </div>

                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="slide" value="1" @if($value['slide'] == 1) checked @endif>

                                                       {{ Lang::get('website.yes') }}
                                            </label>   
                                        </div>
                                    </div>  

                                </div>







                            </div>
                            <div class="modal-footer">
                                <center><button type="submit" class="btn btn-primary">{{ Lang::get('website.save') }}</button></center>
                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <!-- End Edit Post-->
                <!-- Delete Modal -->
                <div class="modal fade" id="delpost{{ $value['idpost'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content modal-lg">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Post</h4>
                            </div>
                            {{ Form::open(array('url'=>action('AdminwebsiteController@postDelete'),'method'=>'POST','class'=>' form-horizontal','id'=>'form1searchcompose','role'=>'search','name'=>'form1searchcompose','files'=>true)) }}

                            <div class="modal-body">


                                <input type='hidden' name='idp'  value='{{$value['idpost']}}'>

                                <input type="text" class="form-control" name='titulli' value='{{ $value['titulli'] }}' disabled>

                                <br>              
                                <textarea name='msg' rows='12' class='form-control' disabled>{{ $value['post'] }} </textarea>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">{{ Lang::get('website.category') }}</span>
                                    {{ Form::select('cat',$cat,$value['catid'],array('class'=>'form-control','disabled')); }}
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Slider:</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="slide"   value="0" @if($value['slide'] == 0) checked @endif disabled >
                                                       {{ Lang::get('website.no') }}
                                            </label>   
                                        </div>

                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="slide" value="1" @if($value['slide'] == 1) checked @endif disabled>

                                                       {{ Lang::get('website.yes') }}
                                            </label>   
                                        </div>
                                    </div>  

                                </div>




                            </div>
                            <div class="modal-footer">
                                <center><button type="submit" class="btn btn-danger">{{ Lang::get('website.delete') }}</button></center>
                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <!-- End Delete Post-->
                </tr>
                @endforeach
            </table>
        </div>                                                              





    </div>
    <!-- end Table-->
    @stop