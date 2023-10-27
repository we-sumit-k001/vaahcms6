@extends("vaahcms::backend.vaahone.layouts.backend")

@section('vaahcms_extend_backend_css')

@endsection


@section('vaahcms_extend_backend_js')

    @if(env('THEME_VAAHTHEME_ENV') == 'develop')
        <script src="http://localhost:8847/vaahtheme/assets/build/app.js" defer></script>
    @else
        <script src="{{vh_theme_assets_url("VaahTheme", "build/app.js")}}"></script>
    @endif

@endsection

@section('content')

    <div id="appVaahTheme">

        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar>

    </div>

@endsection
