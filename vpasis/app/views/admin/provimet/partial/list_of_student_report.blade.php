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