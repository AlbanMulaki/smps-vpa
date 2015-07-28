
<table class="table">
    <tr>
        <th>
    <div class="col-md-1">#</div>
    <div class="col-md-9">Pyetja</div>
    <div class="col-md-1"></div>
    <div class="col-md-1">@if($type==2)<a href=" /smps/admin/ratingprintprof"><span class="fa fa-2x fa-print"></span></a>@endif</div>
</th>
</tr>
@foreach($question as $value)
<tr>
    <td>
        <div class="col-md-1">{{ ++$i }}</div>
        <div class="col-md-9">{{ $value['question'] }}</div>
        <div class="col-md-1">
            <a href="#" data-toggle="modal" data-target="#editlistp{{ $value['id'] }}" class="btn-sm btn-default active"> <span class="fa fa-pencil-square-o"></span></a>
        </div>
        <div class="col-md-1">
            <a href="#" data-toggle="modal" data-target="#dellistp{{ $value['id'] }}" class="btn-sm btn-default active"> <span class="fa fa-trash-o"></span></a>
        </div>



        {{ Form::open(array('action'=>'RatingController@postUpdate','method'=>'POST','class'=>'form')) }}
        <input type='hidden' name='id' value='{{ $value['id'] }}'> 
        <!-- Modal Edit -->
        <div class="modal fade" id="editlistp{{ $value['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <textarea name="question" rows="3" class="form-control" placeholder="Pyetja">{{ $value['question'] }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input name="type" id="optionsRadios1" value="2" type="radio" @if($value['type'] == 2)
                                           checked
                                           @endif>
                                           Professor                        </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input name="type" id="optionsRadios1" value="1" type="radio"
                                           @if($value['type'] == 1)
                                           checked
                                           @endif>
                                           Student                        </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}

        {{ Form::open(array('action'=>'RatingController@postDelete','method'=>'POST','class'=>'form')) }}
        <input type='hidden' name='id' value='{{ $value['id'] }}'> 
        <!-- Modal Delete -->
        <div class="modal fade" id="dellistp{{ $value['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <textarea name="question" rows="3" class="form-control" placeholder="Pyetja" disabled>{{ $value['question'] }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input name="type" id="optionsRadios1" value="2" type="radio" @if($value['type'] == 2)
                                           checked
                                           @endif disabled>
                                           Professor                        </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input name="type" id="optionsRadios1" value="1" type="radio"
                                           @if($value['type'] == 1)
                                           checked
                                           @endif disabled>
                                           Student                        </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ Lang::get('general.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}


    </td>
</tr>




@endforeach

</table>