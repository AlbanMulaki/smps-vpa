@extends('website.index')


@section('content')
<div class="col-md-offset-1 col-md-10 ">
    {{ Session::get('notification')}}
    <div class="well ">
        <center>
            <h3>{{ Lang::get('general.apply_online_student')}}</h3>
        </center>
        {{ Form::open(array('url'=>action('WebsiteController@postAplikoOnlineTani'),'class'=>' form-horizontal','files'=>true)) }}
        <div class="row">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.name') }}</span>
                    <input type="text" name="emri" class="form-control" placeholder="{{ Lang::get('general.name') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.surname') }}</span>
                    <input type="text" name="mbiemri" class="form-control" placeholder="{{ Lang::get('general.surname') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.dad_name') }}</span>
                    <input type="text" name="pemri" class="form-control" placeholder="{{ Lang::get('general.dad_name') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.dad_surname') }}</span>
                    <input type="text" name="pmbiemri" class="form-control" placeholder="{{ Lang::get('general.dad_surname') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col-md-2">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default btn-sm">
                        <input name="gjinia" id="gjinia1" value="{{ Enum::femer}}" type="radio">{{ Lang::get('general.female') }}</label>
                    <label class="btn btn-default btn-sm">
                        <input name="gjinia" id="gjinia2" value="{{ Enum::mashkull }}" type="radio"> {{ Lang::get('general.male') }}</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.birthdate') }}</span>
                    <input type="text" name="datlindja" class="form-control" placeholder="DD/MM/VVVV P.SH 02/07/1994">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.birthplace') }}</span>
                    <input type="text" name="vendlindja" class="form-control" placeholder="{{ Lang::get('general.birthplace') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.idpersonal') }}</span>
                    <input type="text" name="idpersonal" class="form-control" placeholder="{{ Lang::get('general.idpersonal') }}" maxlength="10">
                </div>
            </div>
        </div>

        <div class="row">
            <br>
            <div class="col-md-3">

                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-mobile fa-lg"></span></span>
                    <input type="text" name="mobile" class="form-control" placeholder="{{ Lang::get('general.mobile_format')}}">
                </div>
            </div>
            <div class="col-md-3">

                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.email')}}</span>
                    <input type="text" name="pmbiemri" class="form-control" placeholder="{{ Lang::get('general.email')}}">
                </div>
            </div>
            <div class="col-md-3">

                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.state')}}</span>
                    <select name="shteti" class="form-control">
                        <option value="Kosovë" selected>Kosovë</option>
                        <option value="Shqipëri">Shqipëri</option>
                        <option value="Maqedoni">Maqedoni</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">

                <div class="input-group">
                    <span class="input-group-addon">{{ Lang::get('general.location')}}</span>
                    <input type="text" name="nationality" class="form-control" placeholder="{{ Lang::get('general.location')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col-md-5">
                <div class="row">
                    <textarea name="adressa" rows="3" class="form-control" placeholder="{{ Lang::get('general.adress')}}"></textarea>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-offset-1">
                        <div class="col-md-10">
                            <div class="bg-info">
                                <div class="form-group bg-info">
                                    <p class="bold">{{ Lang::get('general.your_photo')}}</p>
                                    {{ Form::file('img') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-offset-1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="input-group">
                        <span class="input-group-addon">{{ Lang::get('general.profile')}}</span>
                        {{ Form::select('drejtimet',$drejtimi,null,array('class'=>'form-control')) }}
                    </div>
                    <br>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group ">
                            <div class="input-group-addon">{{ Lang::get('general.status') }}</div>
                            {{ Form::select('status',$statusi,null,array('class'=>'form-control')) }}
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="btn-group" data-toggle="buttons">

                            <label class="btn btn-default active">
                                <input name="level" value="1" checked="checked" type="radio"> Bachelor                    </label>
                        </div>
                        <label class="btn btn-default">
                            <input name="transfer" id="transfer1" value="1" type="checkbox">Transfer
                        </label>  </div>
                </div>

                <div class="row">
                    <br>
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.qualification') }}</div>
                        <textarea class="form-control" type="text" name="qualification"></textarea>
                    </div>

                </div>

                <div class="row" id="transferdata">

                    <br>
                    <div class="input-group">
                        <span class="input-group-addon">{{ Lang::get('general.academic_year')}}</span>
                        <select name="vitiaka" class="form-control">
                            <option selected=""></option>
                            <option value="2012/2013">2012/2013</option>
                            <option value="2013/2014">2013/2014</option>
                            <option value="2014/2015">2014/2015</option>
                        </select>
                    </div><br>
                    <p class="bg-info">
                        {{ Lang::get('warn.warn_transfer_student')}}
                    </p>
                </div>
                <script>
                    $(document).ready(function() {
                        if ($('#transfer1:checked').is(':checked') == true) {
                            $('#transferdata').fadeIn('slow').css('display', 'block');
                        } else {
                            $('#transferdata').fadeOut('slow', function() {
                                $('#transferdata').css('display', 'none');
                            });
                        }
                    });
                    $('#transfer1').click(function() {
                        console.log('test');
                        if ($('#transfer1:checked').is(':checked') == true) {
                            $('#transferdata').fadeIn('slow').css('display', 'block');
                        } else {
                            $('#transferdata').fadeOut('slow', function() {
                                $('#transferdata').css('display', 'none');
                            });
                        }
                    });
                </script>
            </div>
        </div>
        <button type="submit" class="btn btn-success">{{ Lang::get('general.apply_now')}}</button>
    </div>
    {{ Form::close() }}
</div>
</div>
@stop