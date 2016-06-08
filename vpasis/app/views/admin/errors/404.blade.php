@extends("admin.index")

@section('content')
<section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> {{ $errorCode }}</h2>

        <div class="error-content">
            <br>
            <h3><i class="fa fa-warning text-yellow"></i> @lang('warn.error.'.$errorCode)</h3>
            <p>
                @lang('warn.error.'.$errorCode.'_description')
            </p>
        </div>
    </div>
</section>
@stop