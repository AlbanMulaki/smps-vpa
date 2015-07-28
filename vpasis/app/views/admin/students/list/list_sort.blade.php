
@section('export')
<a href="{{ action('AdminStudentController@getPrint')."/".$vitiaka}}" class="btn btn-success fa fa-file-excel-o fa-2x" ></a>
<a href="print-slist/" class="btn btn-primary fa fa-file-word-o fa-2x" ></a>
<a href="print-slist/" class="btn btn-danger fa fa-file-pdf-o fa-2x" ></a>
<a href="{{ action('AdminStudentController@getPrint')."/".$vitiaka}}" class="btn btn-default fa fa-print fa-2x" ></a>

@stop

@section('toolbox')
<form class='form-inline' role="form" id="search_sort">
    <div class='form-group'>
        {{ Form::select('sortaca',array(Lang::get('general.select_all'),'2012/2013'=>"2012/2013",'2013/2014'=>"2013/2014",'2014/2015'=>"2014/2015"),$vitiaka,array('class'=>'form-control','id'=>'sortaca','plcaeholder'=>Lang::get('general.by_academy_year'))) }}
    </div> 
    
    <div class="form-group">
        {{ Form::text('searchstudent',"",array('autocomplete'=>"off",'id'=>'searchStudent','class'=>'form-control','placeholder'=>Lang::get('general.search_student'))) }}
    
    <div id="liststudent"></div>
    </div>
    <script>
        
        $('#searchStudent').keyup(function(){
            var datastr = $('#search_sort').serialize();
            $.ajax({
                type: "POST",
                url: "{{ action('AdminStudentController@postSearchStudent') }}",
                data: datastr,
                error: function(){alert('Report to developers')},
                success:function(datastr){console.log(datastr);$('#liststudent').empty().append(datastr)}
            });
        });
    </script>
<div id="listpeople"></div>

    <span style="float:right;">
        @yield('export')
    </span><br><br>
</form>
<script>
    $('#sortaca').change(function() {

        var dataString = $('#sortaca').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('AdminStudentController@postSortaca')}}",
            data: dataString,
            error: function() {
                alert('Something went go wrong');
            },
            success: function(data) {
                console.log(data);
                $('#sorting').empty().append(data);

            }},
        "json");
    });
</script>
@stop




@section('list')
<div class="panel panel-default">
    <div class="panel-heading">

        @yield('toolbox')
    </div>
    <div class="panel-body">
        <nav>
            <ul class="pagination">
                @for($i=0;$i < $page; $i++)
                <li class='
                    @if($i+1 == 1)
                    active 
                    @endif'><a href="#{{ $i+1 }}" role="tab" data-toggle="tab">{{ $i+1 }}</a></li> 
                @endfor
            </ul>
        </nav>
        <!-- Tab panes -->
        <div class="tab-content">
            @for($k=0;$k < $page; $k++)
            <div role="tabpanel" class="tab-pane @if($k+1 == 1)
                 active 
                 @endif" id="{{ $k+1 }}">
                <div class="table-responsive">
                    <table class="table table-striped">

                        <tr>
                            <th>#</th>
                            <th>{{ Lang::get('general.avatar') }}</th>
                            <th>{{ Lang::get('general.student') }}</th>
                            <th>{{ Lang::get('general.adress') }}</th>
                            <th>{{ Lang::get('general.email') }}</th>
                            <th>{{ Lang::get('general.options') }}</th>
                        </tr>
                        @if($k+1==1)
                        @for($j=0 ; $j<20; $j++)
                        <tr>        
                            <td class='text-muted'>{{ $student[$j]['uid'] }}</td>
                            <td class="text-capitalize"> <a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"> <img src='/smpsfile/avatar/{{ $student[$j]['avatar'] }}' class='img-responsive img-circle' width="75" height="75" > </a></td>
                            <td class="text-capitalize"> <a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"> {{ $student[$j]['emri'] }} {{ $student[$j]['mbiemri'] }}</a></td>
                            <td>{{ $student[$j]['adressa'] }}</td>
                            <td>{{ $student[$j]['email'] }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        {{ Lang::get('general.options')}}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"><span class="btn fa fa-edit fa-lg"></span>{{ Lang::get('general.edit')}}</a></li>
                                        <li ><a href="{{ action('AdminStudentController@getDeleteStudent') }}/{{ $student[$j]['uid'] }}" ><span class="btn fa fa-trash-o fa-lg"></span>{{ Lang::get('general.delete')}}</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        @endfor
                        @else 
                        @if( $num - ((20*($k+1))-20) <= 20)

                        @for($j=((20*($k+1))-20) - 1 ; $j< $num; $j++)
                        <tr>        
                            <td class='text-muted'>{{ $student[$j]['uid'] }}</td>
                            <td class="text-capitalize"> <a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"> <img src='/smpsfile/avatar/{{ $student[$j]['avatar'] }}' class='img-responsive img-circle' width="75" height="75" > </a></td>
                            <td class="text-capitalize"> <a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"> {{ $student[$j]['emri'] }} {{ $student[$j]['mbiemri'] }}</a></td>
                            <td>{{ $student[$j]['adressa'] }}</td>
                            <td>{{ $student[$j]['email'] }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        {{ Lang::get('general.options')}}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"><span class="btn fa fa-edit fa-lg"></span>{{ Lang::get('general.edit')}}</a></li>
                                        <li ><a href="{{ action('AdminStudentController@getDeleteStudent') }}/{{ $student[$j]['uid'] }}" ><span class="btn fa fa-trash-o fa-lg"></span>{{ Lang::get('general.delete')}}</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endfor
                        @else
                        @for($j=((20*($k+1))-20) - 1 ; $j< 20*($k+1); $j++)
                        <tr>        
                            <td class='text-muted'>{{ $student[$j]['uid'] }}</td>
                            <td class="text-capitalize"> <a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"> <img src='/smpsfile/avatar/{{ $student[$j]['avatar'] }}' class='img-responsive img-circle' width="75" height="75" > </a></td>
                            <td class="text-capitalize"> <a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"> {{ $student[$j]['emri'] }} {{ $student[$j]['mbiemri'] }}</a></td>
                            <td>{{ $student[$j]['adressa'] }}</td>
                            <td>{{ $student[$j]['email'] }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        {{ Lang::get('general.options')}}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ action('AdminStudentController@getStudent') }}/{{ $student[$j]['uid'] }}"><span class="btn fa fa-edit fa-lg"></span>{{ Lang::get('general.edit')}}</a></li>
                                        <li ><a href="{{ action('AdminStudentController@getDeleteStudent') }}/{{ $student[$j]['uid'] }}" ><span class="btn fa fa-trash-o fa-lg"></span>{{ Lang::get('general.delete')}}</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        @endfor
                        @endif
                        @endif
                    </table>
                </div>


            </div>
            @endfor

        </div>
    </div>
</div>
</div>
@stop

@yield('list')