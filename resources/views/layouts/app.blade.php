<!DOCTYPE html>
<html lang="es">
    <head>
        {{-- Etiquetas --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="robots" content="noindex">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Titulo --}}
        <title>SGE Creditos Complementarios</title>

        {{-- Estilos --}}
        <link rel="stylesheet" href="{{ asset('css/app.css?id=92581470cbdae6474d43') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

        {{-- JS -> SGE --}}
        <script data-dapp-detection="">
            (function() {
            let alreadyInsertedMetaTag = false
            
            function __insertDappDetected() {
                if (!alreadyInsertedMetaTag) {
                const meta = document.createElement('meta')
                meta.name = 'dapp-detected'
                document.head.appendChild(meta)
                alreadyInsertedMetaTag = true
                }
            }
            
            if (window.hasOwnProperty('web3')) {
                // Note a closure can't be used for this var because some sites like
                // www.wnyc.org do a second script execution via eval for some reason.
                window.__disableDappDetectionInsertion = true
                // Likely oldWeb3 is undefined and it has a property only because
                // we defined it. Some sites like wnyc.org are evaling all scripts
                // that exist again, so this is protection against multiple calls.
                if (window.web3 === undefined) {
                return
                }
                __insertDappDetected()
            } else {
                var oldWeb3 = window.web3
                Object.defineProperty(window, 'web3', {
                configurable: true,
                set: function (val) {
                    if (!window.__disableDappDetectionInsertion)
                    __insertDappDetected()
                    oldWeb3 = val
                },
                get: function () {
                    if (!window.__disableDappDetectionInsertion)
                    __insertDappDetected()
                    return oldWeb3
                }
                })
            }
            })()
        </script>
    </head>
    <body>
        <div class="dashboard-page" id="main-container">
            {{-- Navegacion --}}
            <nav class="navbar navbar-default navbar-fixed-top" id="main-navbar">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand hidden-sm hidden-md hidden-lg">
                            @yield('nombreUsuario')
                        </a> 
                        <button type="button" data-toggle="collapse" data-target="#collapse-menu-1" aria-expanded="false" id="menu-collapse" class="navbar-toggle collapsed">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span> 
                            <span class="icon-bar"></span> 
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse hidden-xs" id="collapse-menu-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle navbar-text" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    @yield('nombreUsuario')
                                    <img src="{{ asset('img/user.svg') }}" alt="Usuario" class="img-navbar">
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}">Cerrar sesión</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            {{-- Menu --}}
            <aside class="sidebar in" id="main-sidebar" role="navigation">
                <div class="sidebar-logo">
                    <img src="{{ asset('img/sge_white.png') }}" alt="Logo" class="img-logo">IT morelia
                </div>
                <div class="sidebar-outer">
                    <div class="side-menu">
                        @yield('menu')
                        <div class="item">
                            <a href="#collapse-15" class="item-dropdown" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-15"><i class="fa  fa-chevron-circle-right "></i>    Opciones</a>
                            <div class="collapse" id="collapse-15">
                                <div class="item">
                                    <a href="{{ route('password') }}" class="item-dropdown">Cambiar contraseña</a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <a href="#" class="item-dropdown" id="close-main-sidebar"><i class="fa fa-arrow-circle-left"></i> Ocultar menú</a>
                        </div>
                    </div>
                </div>
            </aside>
            <a href="#" class="float-button bottom-left in" id="open-main-sidebar"><i class="fa fa-arrow-circle-right"></i> Mostrar menú</a>

            {{-- Cuerpo --}}
            <div class="body-container animated fadeIn">
                <div class="container-fluid">
                    <br>
                    @yield('contenido')
                </div>
            </div>
        </div>

        {{-- JavaScript --}}
        <script src="{{ asset('js/app.js?id=a134990f66450c627594') }}"></script>
        <script>
            console.log('------------------------------------------------');
            console.log('| CREADORES DE LA APLICACIÓN                   |');
            console.log('| CARLOS JAHIR CASTRO CAZARES | 17120151       |');
            console.log('| GIOVANNI HASID MARTINEZ RESENDIZ | 17120182  |');
            console.log('| AURELIO AMAURY CORIA RAMÍREZ                 |');
            console.log('------------------------------------------------');
        </script>
        @yield('errores')
    </body>
</html>