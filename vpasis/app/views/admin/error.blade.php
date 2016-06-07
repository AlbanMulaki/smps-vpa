@extends('admin.index')


@section('content')

<section class='content-header'>
    <h1>
        404 Error Page
    </h1>
</section>
<section class='content'>
    <div class='error-page'>
        <h2 class='headline text-yellow'>404</h2>
        <div class='error-content'>
            <h3>
                <i class='fa fa-warning text-yellow'>
                    Oops! Page not found.
                </i>
            </h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href='#'> return to dashboard</a>
            </p>
        </div>
    </div>
</section>

@stop


