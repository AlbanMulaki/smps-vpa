@extends('admin.index')

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-body">
            Panel 
        </div>
        <div class="panel-footer">
            <form>
                <div class="row">
                    <div class="col-md-2">
                        <label>Disable Web:</label>
                    </div>
                    <br>
                    <div class="col-md-2">
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Po
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Jo
                        </label>
                    </div>  

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <br>
                        <label>Slider:</label>
                    </div>
                    <br><br>
                    <div class="col-md-2">
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Po
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Jo
                        </label>

                    </div>  

                </div>

            </form>
        </div>
    </div>
</div>
@stop