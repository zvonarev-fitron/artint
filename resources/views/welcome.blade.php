<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="css/app.css" rel="stylesheet" type="text/css">

        <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.3/vue.min.js'></script>
        <script src='https://unpkg.com/vue-yandex-maps'></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 30px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            #app {
                width: 100%;
                /*height: 500px;*/
                border: 1px solid red;
            }

            .ymap {
                height: 100%;
            }
            .red {
                color: red;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/order') }}">Добавить заявку</a>
                    @else
                        <a href="{{ route('login') }}">Войти</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Регистрация</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="content">
                <div class="title m-b-md">Система поиска заявок пользователей</div>
                <div id="app">
                    <yandex-map
                            :coords="[47.2501, 39.6569]"
                            zoom="10"
                            class="ymap"
                            style="width: 1200px; height: 800px;"
                            :cluster-options="{1: {clusterDisableClickZoom: true}}"
                            :behaviors="['default']"
                            :controls="['searchControl']"
                            :placemarks="placemarks"
                            map-type="map"
                            {{--@map-was-initialized="initHandler"--}}
                    >
                        @foreach($params['orders'] as $order)
                            <ymap-marker
                                    marker-id="{{ $order->id }}"
                                    marker-type="Placemark"
                                    :coords="[{{ $order->coord_l }}, {{ $order->coord_w }}]"
                                    hint-content='{{ $order->order }}'
                                    :balloon="{header: '{{ $order->fio }}', body: '{{ $order->order }}', footer: '{{ $order->city }}<br>{{ $order->address }}'}"
                                    {{--:icon="{color: 'green', glyph: 'cinema'}"--}}
                                    cluster-name="1"
                            ></ymap-marker>
                        @endforeach
                    </yandex-map>
                </div>
            </div>
        </div>
    </body>
    <script >
        new Vue({
                el: '#app',
                data() {
                    return {
                        placemarks: [
                            // {
                            //     coords: [54.8, 39.8],
                            //     properties: {}, // define properties here
                            //     options: {closeButton: false}, // define options here
                            //     closeButton: false,
                            //     clusterName: "1",
                            //     balloonTemplate: '<h1 class="red">фй, eыцыувувкаепеп!</h1><p>I am here: 1234567</p><img src="http://via.placeholder.com/350x150">',
                            //     callbacks: { click: function() {} }
                            // }
                        ]
                    }
                },
                computed: {
                    balloonTemplate() {
                        return '<h1 class="red">фй, eыцыувувкаепеп!</h1><p>I am here: 1234567</p><img src="http://via.placeholder.com/350x150">'
                    }
                }
            }
        );
    </script>
</html>
