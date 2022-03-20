<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Get reporte usuarios */
// Route::get('get-usuarios/csv', 'InicioController@getUsuarios');

/* Rutas de invitados */
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return redirect()->route('inicio');
    });
    Route::get('/login', 'InicioController@inicio')->name('inicio');
    Route::get('/login/administrativo', 'InicioController@loginAdminsitrativo')->name('login.administrativo');
    Route::get('/login/alumno', 'InicioController@loginAlumno')->name('login.alumno');
});

/* Rutas de inicio y cierre de Sesion */
Route::post('/autenticacion/administrativo', 'Auth\LoginController@loginAdministrativo')->name('autenticacion.administrativo');
Route::post('/autenticacion/alumno', 'Auth\LoginController@loginAlumno')->name('autenticacion.alumno');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

/* Rutas para usuarios autenticados */
Route::group(['middleware' => ['auth']], function () {

    /* Ruta para cambio de password */
    Route::get('/cambiar-password', 'UsuarioController@changePassword')->name('password');
    Route::post('/update-password', 'UsuarioController@updatePassword')->name('update.password');

    /* Rutas para alumnos */
    Route::group(['middleware' => ['alumno']], function () {
        Route::group(['prefix' => 'alumnos'], function () {
            Route::get('/', 'Alumno\AlumnoController@inicio')->name('inicio.alumno');
            Route::group(['prefix' => 'creditos-complementarios'], function () {
                Route::get('/expediente', 'Alumno\ExpedienteCreditosController@expediente')->name('alumno.expediente');
                Route::post('/expediente/abrir', 'Alumno\ExpedienteCreditosController@abrirExpediente')->name('alumno.expediente.abrir');
                Route::match(['get', 'post'], '/agregar-credito/seleccion', 'Alumno\ActividadesRegistradasController@seleccionarCredito')->name('alumno.agregar.credito.seleccion');
                Route::match(['get', 'post'], '/agregar-credito/informacion', 'Alumno\ActividadesRegistradasController@registrarActividad')->name('alumno.agregar.credito.informacion');
                Route::post('/responsables-departamento/{idDepartamento}', 'ResponsableActividad\ResponsableActividadController@getResponsableDepartamento');
                Route::post('/registrar-credito', 'Alumno\ActividadesRegistradasController@registrarCredito')->name('alumno.registrar.credito');
                Route::match(['get', 'post'], '/rubrica-de-evaluacion', 'ResponsableActividad\RubricaEvaluacionController@rubricaEvaluacionAlumno')->name('alumno.rubrica.actividad');
                Route::match(['get', 'post'], '/actividad-complementaria/editar', 'Alumno\ActividadesRegistradasController@editarActividad')->name('alumno.actividad.editar');
                Route::match(['get', 'post'], '/actividad-complementaria/cambiar/modo-editar/actividad-complementaria', 'Alumno\ActividadesRegistradasController@editarModoEdicion')->name('alumno.actividad.cambiar.editar');
                Route::post('/editar-credito', 'Alumno\ActividadesRegistradasController@updateCredito')->name('alumno.update.actividad.credito');
                Route::post('/editar-actividad', 'Alumno\ActividadesRegistradasController@updateActividad')->name('alumno.update.actividad');
            });
        });
    });
    /* Rutas para el responsable de la actividad */
    Route::group(['middleware' => ['responsableActividad']], function () {
        Route::group(['prefix' => 'responsable-actividad-complementaria'], function () {
            Route::get('/', 'ResponsableActividad\ResponsableActividadController@inicio')->name('inicio.responsable');
            
            //Captura por alumno
            Route::get('/rubricas-alumno', 'ResponsableActividad\ResponsableActividadController@showRubricasAlumno')->name('responsable.rubricas-alumno');
            Route::get('/evaluar-alumno/{alumno}', 'ResponsableActividad\ResponsableActividadController@showAlumno')->name('responsable.alumno');
            Route::post('/calificar-rubrica', 'ResponsableActividad\ResponsableActividadController@calificarRubrica')->name('responsable.calificar.rubrica');
            Route::post('/rechazar-actividad/{alumno}', 'ResponsableActividad\ResponsableActividadController@rechazarActividad')->name('responsable.actividad.rechazar');

            //Captura masiva
            Route::get('/evaluar-actividades', 'ResponsableActividad\ResponsableActividadController@indexActividades')->name('responsable.actividades');
            Route::get('/evaluar-actividad-alumnos/{credito}', 'ResponsableActividad\ResponsableActividadController@showActividad')->name('responsable.actividad');
            Route::post('/rechazar-actividad/v1', 'ResponsableActividad\ResponsableActividadController@rechazarActividad')->name('responsable.actividad.rechazar.v1');
            Route::get('/evaluar-rubrica-actividad/{rubrica}', 'ResponsableActividad\RubricaEvaluacionController@rubricaIndividual')->name('responsable.rubrica.individual');
            Route::post('/califiacar-rubrica-individual-v1', 'ResponsableActividad\ResponsableActividadController@calificarRubricaV1')->name('responsable.calificar.rubrica.v1');
            Route::get('/evaluar-rubricas-alumnos/{credito}/actividad', 'ResponsableActividad\RubricaEvaluacionController@rubricasActividad')->name('responsable.rubrica.masivamente');
            Route::post('/califiacar-rubricas-masivamente', 'ResponsableActividad\ResponsableActividadController@calificarRubricasMasivamente')->name('responsable.calificar.rubricas.masivamente');

        });
    });
    /* Rutas para docencia */
    Route::group(['middleware' => ['docencia']], function () {
        Route::group(['prefix' => 'proyecto-docencia'], function () {
            Route::get('/', 'ProyectoDocencia\ProyectoDocenciaController@inicio')->name('inicio.docencia');

            Route::get('/usuarios', 'UsuarioController@index')->name('usuarios.index');
            Route::post('/usuario/restore-password', 'UsuarioController@restorePassword')->name('usuarios.restorePassword');

            Route::group(['prefix' => 'creditos-complemetarios'], function () {
                Route::get('/buscar-expediente-alumno', 'ProyectoDocencia\ProyectoDocenciaController@buscarExpedienteAlumno')->name('docencia.buscar.expediente.alumno');
                Route::post('/buscar-expediente', 'Alumno\ExpedienteCreditosController@buscarExpediente')->name('docencia.expediente.buscar');
                Route::get('/expediente-alumno/{numeroControl}', 'ProyectoDocencia\ProyectoDocenciaController@expedienteAlumno')->name('docencia.expediente.alumno');
                Route::match(['get', 'post'], '/expediente-alumno/{numeroControl}/rubrica-de-evaluacion/{rubrica}', 'ResponsableActividad\RubricaEvaluacionController@rubricaEvaluacionDocencia')->name('docencia.rubrica.actividad');
                Route::post('/evaluar-actividad', 'ProyectoDocencia\ProyectoDocenciaController@evaluarActividad')->name('docencia.evaluar.actividad');
                Route::post('/subir-constancia/cerrar-expediente', 'ProyectoDocencia\ProyectoDocenciaController@cerrarExpediente')->name('docencia.cerrar.expediente');
                /* Genera archivo de plantilla word */
                Route::get('/descargar/plantilla-carta-liberacion/{numeroControl}','ProyectoDocencia\GeneradorArchivosController@descargarPlantillaCreditos')->name('docencia.descargar.plantilla.constancia');

                //Buscar por carrera
                Route::get('/carrera', 'ProyectoDocencia\ProyectoDocenciaController@buscarExpedientesCarrera')->name('docencia.buscar.expediente.carrera');
                Route::post('/buscar-carrera', 'Alumno\ExpedienteCreditosController@buscarCarrera')->name('docencia.carrera.buscar');
                Route::get('/expediente-carrera/{carrera}', 'ProyectoDocencia\ProyectoDocenciaController@expedienteCarrera')->name('docencia.expediente.carrera');
                
                //Buscar expedientes
                Route::get('/expedientes', 'ProyectoDocencia\ProyectoDocenciaController@buscarExpedientesGeneral')->name('docencia.buscar.expedientes');
                Route::post('/buscar-expedientes', 'Alumno\ExpedienteCreditosController@buscarExpedientes')->name('docencia.expedientes.buscar');
                Route::get('/expedientes/{estatus}', 'ProyectoDocencia\ProyectoDocenciaController@expedientes')->name('docencia.expedientes');

                //Buscar pendientes
                Route::get('/pendientes', 'ProyectoDocencia\ProyectoDocenciaController@buscarExpedientesPendientes')->name('docencia.buscar.pendientes');
                Route::post('/buscar-pendientes', 'Alumno\ExpedienteCreditosController@buscarPendientes')->name('docencia.pendientes.buscar');

                Route::get('/pendientes-filtro/{inicio}/{fin}/{semestre?}/{carrera?}', 'ProyectoDocencia\ProyectoDocenciaController@filtroPendientes')->name('docencia.pendientes.filtro');
                Route::get('/pendientes-filtro-carrera/{inicio}/{fin}/{carrera}', 'ProyectoDocencia\ProyectoDocenciaController@filtroPendientesCarrera')->name('docencia.pendientes.filtro.carrera');
                Route::get('/pendientes-semestre/{semestre}/{carrera?}', 'ProyectoDocencia\ProyectoDocenciaController@pendientesSemestre')->name('docencia.pendientes.semestre');
                Route::get('/pendientes-carrera/{carrera}', 'ProyectoDocencia\ProyectoDocenciaController@pendientesCarrera')->name('docencia.pendientes.carrera');

                //Generar Archivos CSV
                Route::get('/generarCSVCarrera/{carrera}', 'ProyectoDocencia\GeneradorArchivosController@csvCarrera')->name('docencia.csv.carrera');
                Route::get('/generarCSVEstatus/{estatus}', 'ProyectoDocencia\GeneradorArchivosController@csvEstatus')->name('docencia.csv.estatus');
                Route::get('/generarCSVPendientes', 'ProyectoDocencia\GeneradorArchivosController@csvPendientes')->name('docencia.csv.pendientes');

                //Generador CSV con condiciones
                Route::get('/generarCSVPendientes-filtro/{inicio}/{fin}/{semestre?}/{carrera?}', 'ProyectoDocencia\GeneradorArchivosController@csvPendientesFiltro')->name('docencia.csv.pendientes.filtro');
                Route::get('/generarCSVPendientes-filtro-carrera/{inicio}/{fin}/{carrera}', 'ProyectoDocencia\GeneradorArchivosController@csvPendientesFiltroCarrera')->name('docencia.csv.pendientes.filtro.carrera');
                Route::get('/generarCSVPendientes-semestre/{semestre}/{carrera?}', 'ProyectoDocencia\GeneradorArchivosController@csvPendientesSemestre')->name('docencia.csv.pendientes.semestre');
                Route::get('/generarCSVPendientes-carrera/{carrera}', 'ProyectoDocencia\GeneradorArchivosController@csvPendientesCarrera')->name('docencia.csv.pendientes.carrera');   

            });
        });
    });
    /* Rutas para jefe de servicio social y escolares */
    Route::group(['middleware' => ['social-escolares']], function () {
        Route::group(['prefix' => 'jefe-servicio-social-escolares'], function () {
            Route::get('/', 'SocialEscolaresController@inicio')->name('inicio.socialEscolares');
            Route::group(['prefix' => 'creditos-complemetarios'], function () {
                Route::get('/buscar-expediente', 'SocialEscolaresController@buscarExpediente')->name('socialEscolares.buscar.expediente');
                Route::post('/buscar-expediente/alumno', 'SocialEscolaresController@buscarExpedienteAlumno')->name('socialEscolares.buscar.expediente.alumno');
                Route::get('/expediente-alumno/{numeroControl}', 'SocialEscolaresController@expedienteAlumno')->name('socialEscolares.expediente.alumno');
                Route::get('/alumnos/expedientes-cerrados', 'SocialEscolaresController@expedientesCerrados')->name('socialEscolares.expedientes.cerrados');
                /* Generar CSV */
                Route::get('/generar-csv/tabla-expedientes-cerrados', 'ProyectoDocencia\GeneradorArchivosController@csvExpedientesCerrados')->name('socialEscolares.csv.expedientes.cerrados');
            });
        });
    });
});