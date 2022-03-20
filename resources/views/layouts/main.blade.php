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
    {{-- Cuerpo --}}
    <div id="main-container" class="container-fluid single-page">
      <div class="middle-panel-login">
        <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <div class="row">
              <div class="col-sm-2 col-sm-offset-5 col-xs-4 col-xs-offset-4">
                <img src="{{ asset('img/sge_white.png') }}" alt="SGE" class="img-responsive">
              </div>
            </div>
            <br>
            {{-- Contenido --}}
            @yield('contenido')
          </div>
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
    {{-- Errores --}}
    @yield('errores')
  </body>
</html>