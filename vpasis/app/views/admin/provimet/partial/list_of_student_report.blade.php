<table class='table table-bordered'>

    <thead>
        <tr>
            <td colspan="13">
                <div class='col-md-10'> 
                    <h4><b>{{ Lang::get('general.course') }}</b>: {{ $raporti->lendet->Emri }}<br>
                        <b>{{ Lang::get('general.lecturer')}}:</b> <span data-toggle="tooltip" data-placement="left" title="UID:{{ $raporti->administrata->uid }}" > {{ $raporti->administrata->emri." ".$raporti->administrata->mbiemri }}</span><br>
                        <b>{{ Lang::get('general.date') }}</b>: {{ $raporti->data_provimit }}</h4>
                </div>
                <div class='col-md-2'>
                    <div class="text-right">
                        <a href="{{ action('ProvimetController@getPrintReportNotat',[$raporti->id,1]) }}" class="btn btn-sm btn-danger" ><span class="fa fa-file-pdf-o" ></span></a>
                        <a href="{{ action('ProvimetController@getPrintReportNotat',$raporti->id) }}" class="btn btn-sm btn-default" ><span class="fa fa-print" ></span></a>
                    </div>
                </div>

            </td>

        </tr>
        <tr>
            <th>{{ Lang::get('general.student') }}</th>
            <th>{{ Lang::get('general.studentId') }}</th>
            <th>{{ Lang::get('general.test_semester') }}</th>
            <th>{{ Lang::get('general.test_semisemester') }}</th>
            <th>{{ Lang::get('general.seminar') }}</th>
            <th>{{ Lang::get('general.attendance') }}</th>
            <th>{{ Lang::get('general.practice_work') }}</th>
            <th>{{ Lang::get('general.final_test') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.grade') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.refuse') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.apply') }}</th>
            <th  style='width: 80px;'>{{ Lang::get('general.present') }}</th>
            <th  style='width: 80px;'> &nbsp;</th>
        </tr>
    </thead>
    <tbody>


{{ "";$i=0 }}
@foreach($raporti->raportiNotaveStudent as $value)
        <tr class="provRow">
            <td>
                <input name="name_surname[]" class='form-control input-sm' type='text' value='{{ $value->getStudent->emri." ".$value->getStudent->mbiemri }}' />
            </td>
            <td>
                <input name="uid[]" class='form-control input-sm' type='number' min="0" value='{{ $value->getStudent->uid }}' />
            </td>
            <td>
                <input name="testi_semestral[]" class='form-control input-sm' type='number' min="0" value='{{ $value->testi_semestral }}' />
            </td>
            <td>
                <input name="testi_gjysemsemestral[]" class='form-control input-sm' type='number' min="0" value='{{ $value->testi_gjysem_semestral }}' />
            </td>
            <td>
                <input name="seminari[]" class='form-control input-sm' style='width:60px;' type='number' min="0" value='{{ $value->seminari }}' />
            </td>
            <td>
                <input name="pjesmarrja[]" class='form-control input-sm' style='width:60px;' type='number' min="0" value='{{ $value->pjesmarrja }}' />
            </td>
            <td>
                <input name="praktike[]" class='form-control input-sm' type='number' value='{{ $value->puna_praktike }}' />
            </td>
            <td>
                <input name="testi_final[]" class='form-control input-sm' style='width:60px;' type='number' value='{{ $value->testi_final }}' />
            </td>
            <td>
                {{ Form::selectRange('nota[]', 5,10,$value['nota'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>

                {{ Form::select('refuzim[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),$value['refuzim'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),$value['paraqit'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit_prezent[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),$value['paraqit_prezent'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                <a href="{{ action('ProvimetController@getDeleteStudent',[$raporti->id,$value->getStudent->uid]) }}" class="btn-danger btn btn-sm"><i class="fa fa-lg fa-close"></i></a>
            </td>
        </tr>
        {{ "";$i++ }}
@endforeach


@for($j=0; $j<5; $j++)
        <tr class="provRow">
            <td>
                <input name="name_surname[]" class='form-control input-sm' type='text'/>
            </td>
            <td>
                <input name="uid[]" class='form-control input-sm' type='number' min="0" />
            </td>
            <td>
                <input name="testi_semestral[]" class='form-control input-sm' type='number' min="0" />
            </td>
            <td>
                <input name="testi_gjysemsemestral[]" class='form-control input-sm' type='number' min="0" />
            </td>
            <td>
                <input name="seminari[]" class='form-control input-sm' style='width:60px;' type='number' min="0" />
            </td>
            <td>
                <input name="pjesmarrja[]" class='form-control input-sm' style='width:60px;' type='number' min="0" />
            </td>
            <td>
                <input name="praktike[]" class='form-control input-sm' type='number' />
            </td>
            <td>
                <input name="testi_final[]" class='form-control input-sm' style='width:60px;' type='number' />
            </td>
            <td>
                {{ Form::selectRange('nota[]', 5,10,5,array('class'=>'form-control input-sm')) }}
            </td>
            <td>

                {{ Form::select('refuzim[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),Enum::NO,array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),Enum::YES,array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit_prezent[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),Enum::NO,array('class'=>'form-control input-sm')) }}
            </td>
        </tr>
        {{ "";$i++ }}
@endfor
    </tbody>
</table>