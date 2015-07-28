@extends('student.index')

@section('content')
{{ Form::open(array('url'=>action('StudentController@postNotimet'),'method'=>'POST','class'=>' form-horizontal')) }}

<div class='container'>
    {{ Session::get('notification') }}
    <div class='table-responsive'>
        <table class='table'>
            <tr>
                <th>#</th>
                <th>{{ Lang::get('general.course') }}</th>
                <th>{{ Lang::get('general.grade') }}</th>
                <th>{{ Lang::get('general.lecturer') }}</th>
                <th>{{ Lang::get('general.date') }}</th>
                @if($setting['provim_active'] == Enum::active)
                <th>{{ Lang::get('general.refuse') }}</th>
                <th>{{ Lang::get('general.apply_exams') }}</th> 
                @endif
                <th>{{ Lang::get('general.vijushmeria') }}</th>
            </tr>
            @foreach($lendet as $value)
            <tr>
                <td>{{$i++}}</td>
                <td>{{ $value['Emri'] }}</td>
                <td>@if($value['refuzimi']<1){{ $value['nota'] }}@endif</td>
                <td>{{ $value['professori'] }}</td>
                <td>{{ $value['data_provimit']}}</td>
                @if($setting['provim_active'] == Enum::active)
                @if($value['Dif'] <= $setting['koha_refuzimit']  && $value['nota'] > 5 && $value['refuzimi'] == 0)
                <td><input type="checkbox" name='ref[]' id='paraqit{{ $value['idl'] }}' value='{{ $value['idnew_table'] }}'></td>
                @else 
                <td> </td>
                @endif

                @if($value['paraqitja'] == 0)
                <td><input type="checkbox" name='par[]' id="lendet{{ $value['idl'] }}" value='{{ $value['idnew_table'] }}'></td>
                @elseif($value['paraqitja'] == 1)
                <td><span class="fa fa-clock-o"></span></td>
                @else 
                <td> <span class='fa fa-check-square'></span>
                </td>
                @endif
                @endif
                @if($value['vijushmeria'] == 0)
                <td>{{ $value['vijushmeria'] }} <span class='label @if($value['vijushmeria']/$setting['oret_planifikuara']*100 >75)
                                                      label-success
                                                      @else 
                                                      label-danger
                                                      @endif' >0 %</span></td>
                @else 

                <td>{{ $value['vijushmeria'] }} <span class='label @if($value['vijushmeria']/$setting['oret_planifikuara']*100 >75)
                                                      label-success
                                                      @elseif($value['vijushmeria']/$setting['oret_planifikuara']*100 >50)
                                                      label-warning
                                                      @else 
                                                      label-danger
                                                      @endif' >{{ $value['vijushmeria']/$setting['oret_planifikuara']*100 }}%</span></td>
                @endif
            </tr>
            @endforeach
            <tr>
                <td></td>
            </tr>
        </table>
        @if($setting['provim_active'] == Enum::active)
        <div class="container ">
            <button type="submit" class="btn btn-lg btn-success center-block"> {{ Lang::get('general.register')}} </button>
        </div>
        @endif
        <br>
        <br>
    </div>
</div>
{{ Form::close() }}
@stop