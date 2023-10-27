@extends("vaahtheme::frontend.layouts.default")

@section('vaahcms_extend_frontend_head')

@endsection

@section('vaahcms_extend_frontend_css')

@endsection

@section('vaahcms_extend_frontend_scripts')

@endsection

@section('content')

<div class="container has-text-centered mt-6">

        <div class="notification is-link is-light">
            This is the home page when marked as home from the CMS menu
        </div>

        <section class="hero">
            <div class="hero-body">
                <p class="title">{!! config('settings.global.site_title'); !!}</p>

                <p class="subtitle">Home Page</p>



            </div>
        </section>

    <footer>
        <div>
            {!! config('settings.global.copyright_text_custom'); !!}

            {!! config('settings.global.copyright_text'); !!}


        </div>
    </footer>

</div>
@endsection
