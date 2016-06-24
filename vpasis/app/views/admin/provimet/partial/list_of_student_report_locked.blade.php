<table class='table table-bordered'>

    <thead>
        <tr>
            <td colspan="12">
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
            <th style="min-width: 100px;">{{ Lang::get('general.student') }}</th>
            <th>{{ Lang::get('general.studentId') }}</th>
            <th>{{ Lang::get('general.test_semester') }}</th>
            <th>{{ Lang::get('general.test_semisemester') }}</th>
            <th>{{ Lang::get('general.seminar') }}</th>
            <th>{{ Lang::get('general.attendance') }}</th>
            <th>{{ Lang::get('general.practice_work') }}</th>
            <th>{{ Lang::get('general.final_test') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.grade') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.refuse') }}</th>
            <th  style='width: 80px;'>{{ Lang::get('general.present') }}</th>
        </tr>
    </thead>
    <tbody>


{{ "";$i=0 }}
@foreach($raporti->raportiNotaveStudent as $value)
        <tr class="provRow">
            <td>
                {{ $value->getStudent->emri." ".$value->getStudent->mbiemri }}
            </td>
            <td>
                {{ $value->getStudent->uid }}
            </td>
            <td>
                {{ $value->testi_semestral }}
            </td>
            <td>
                {{ $value->testi_gjysem_semestral }}
            </td>
            <td>
               {{ $value->seminari }}
            </td>
            <td>
                {{ $value->pjesmarrja }}
            </td>
            <td>
                {{ $value->puna_praktike }}
            </td>
            <td>
                {{ $value->testi_final }}
            </td>
            <td>
                {{ $value->nota }}
            </td>
            <td>
                {{ Enum::convertrefuzimin($value->refuzim) }}
            </td>
            <td>
                {{ Enum::convertParaqitjen($value->paraqit_prezent) }}
             </td>
            
        </tr>
        {{ "";$i++ }}
@endforeach

    </tbody>
</table>