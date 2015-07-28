@extends('admin.index')
{{--
@section('content')
<style>
    .cat1{
        list-style: none;
        border-style-right: 5px solid #C20;

    }

    .cat2{
        list-style: none;
    }
</style>





<div class="row">


    <div class="container">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-body">
                    {{ Lang::get('website.quickmenu')}}
                </div>
                <div class="panel-footer">  
                    <div class="input-group">
                        <span class="input-group-addon">{{ Lang::get('general.name') }}</span>
                        <input type="text" class="form-control">
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon">{{ Lang::get('general.link') }}</span>
                        <input type="text" class="form-control">
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Menu</label>
                        </div>
                        <div class="col-md-2">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                    Yes
                                </label>   
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option2" checked>
                                    No
                                </label>   
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group"><span class="input-group-addon">Prioriteti:</span><input type="text" class="form-control"></div>
                            <br>

                        </div>
                    </div>
                    <center><button type="button" class="btn btn-primary">Save</button></center>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Emri</th>
                                <th>Link</th>
                                <th>Menu</th>
                                <th>Prioriteti</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <td>1</td>
                        <td>Test</td>
                        <td>linki1</td>
                        <td><span class="fa fa-circle" style="color:#00CC00"></span></td> 
                        <td>2</td>
                        <td><i class="fa fa-pencil-square-o"></i></td>
                        <td><i class="fa fa-trash-o"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Emri2</td>
                            <td>Category2</td>
                            <td><span class="fa fa-circle" style="color:red"></span></td>
                            <td>1</td>
                            <td><i class="fa fa-pencil-square-o"></i></td>
                            <td><i class="fa fa-trash-o"></i></td>

                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Emri3</td>
                            <td>Category3</td>
                            <td><span class="fa fa-circle" style="color:green"></span></td>
                            <td>4</td>
                            <td><i class="fa fa-pencil-square-o"></i></td>
                            <td><i class="fa fa-trash-o"></i></td>

                        </tr>
                    </table></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-body">
                    Category
                </div>
                <div class="panel-footer">  <div>
                        <div class="input-group">
                            <span class="input-group-addon">Emri:</span>
                            <input type="text" class="form-control">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">Link</span>
                            <input type="text" class="form-control">
                        </div></div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Menu:</label>
                        </div>
                        <div class="col-md-2">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                    Yes
                                </label>   
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option2" checked>
                                    No
                                </label>   
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group"><span class="input-group-addon">Prioriteti:</span><input type="text" class="form-control"></div>
                        <br>

                    </div>
                    <center><button type="button" class="btn btn-primary">Save</button></center>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Emri</th>
                                <th>Parent Category</th>
                                <th>Menu</th>
                                <th>Prioriteti</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <td>1</td>
                        <td>Test</td>
                        <td>linki1</td>
                        <td><span class="fa fa-circle" style="color:#00CC00"></span></td> 
                        <td>2</td>
                        <td><i class="fa fa-pencil-square-o"></i></td>
                        <td><i class="fa fa-trash-o"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Emri2</td>
                            <td>Category2</td>
                            <td><span class="fa fa-circle" style="color:red"></span></td>
                            <td>1</td>
                            <td><i class="fa fa-pencil-square-o"></i></td>
                            <td><i class="fa fa-trash-o"></i></td>

                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Emri3</td>
                            <td>Category3</td>
                            <td><span class="fa fa-circle" style="color:green"></span></td>
                            <td>4</td>
                            <td><i class="fa fa-pencil-square-o"></i></td>
                            <td><i class="fa fa-trash-o"></i></td>

                        </tr>
                    </table>
                </div></div>
        </div>
    </div>

</div>


</div>
@stop
--}
@section('content')
......
@stop