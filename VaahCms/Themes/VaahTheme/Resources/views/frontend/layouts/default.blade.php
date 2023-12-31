<!DOCTYPE html>
<html lang="en">
    <head>
        {!! config('settings.global.script_after_head_start') !!}

        @if(isset($title) && $title)
            <title>{{$title}}</title>
        @elseif(isset($data) && (is_array($data) || is_object($data)) && is_subclass_of($data, 'Illuminate\Database\Eloquent\Model'))
            {!! get_field($data, 'seo-meta-tags') !!}
        @else
            <title>VaahTheme</title>
        @endif

        <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

        <base href="{{\URL::to('/')}}">

        <meta name="current-url" id="current_url" content="{{ url()->current() }}">

        <meta name="debug" id="debug" content="true">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vaahcss@latest/css/vaahcss.min.css" />
        <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
        <link rel="stylesheet" href="http://localhost/Sumit/VaahCmsTraining/vaahcms5/VaahCms/Themes/VaahTheme/Vue/node_modules/buefy/dist/buefy.css">

        <!--
        @if(env('THEME_VAAHTHEME_ENV') == 'develop')
            <link href="http://localhost:8080/vaahtheme/assets/css/build.css"
                  rel="stylesheet" media="screen">
            <link href="http://localhost:8080/vaahtheme/assets/css/style.css"
                  rel="stylesheet" media="screen">
        @else
            <link  href="{{vh_theme_assets_url("VaahTheme", "css/build.css")}}"
                   rel="stylesheet" media="screen">
            <link  href="{{vh_theme_assets_url("VaahTheme", "css/style.css")}}"
                rel="stylesheet" media="screen">
        @endif
        -->

        @yield('vaahcms_extend_frontend_head')

        @yield('vaahcms_extend_frontend_css')

        {!! config('settings.global.script_before_head_close') !!}
    </head>

	<body>
        {!! config('settings.global.script_after_body_start') !!}

        @include("vaahcms::frontend.partials.errors")
        @include("vaahcms::frontend.partials.flash")

        @yield('content')

        <script src="https://unpkg.com/jquery@3.6.0/dist/jquery.js"></script>
        <script src="https://unpkg.com/axios@0.21.1/dist/axios.min.js"></script>
        <script src="https://unpkg.com/vue@2.6.14/dist/vue.js"></script>
        <script src="http://localhost/Sumit/VaahCmsTraining/vaahcms5/VaahCms/Themes/VaahTheme/Vue/node_modules/buefy/dist/buefy.min.js"></script>
        <script src="{{vh_theme_assets_url("VaahTheme", "build/script.js")}}"></script>


        @yield('vaahcms_extend_frontend_scripts')

        {!! config('settings.global.script_before_body_close') !!}
	</body>
</html>
