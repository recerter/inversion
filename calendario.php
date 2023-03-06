    <?php require_once ('header.php');
	require_once TS_CLASS.'c.calendario.php';
	$cCalendario = new calendario(); 
	?>
    <link href="vendor/fullcalendar/css/main.min.css" rel="stylesheet">   
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Calendario</h4>
                            <p class="mb-0"></p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Calendario</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-intro-title">Calendar</h4>

                                <div class="">
                                    <div id="external-events" class="my-3">
                                        <div class="external-event btn-warning light" data-class="bg-warning"><i class="fa fa-move"></i>Registro</div>
                                        <div class="external-event btn-primary light" data-class="bg-primary"><i class="fa fa-move"></i><span>Objetivo Creado</span></div>
                                        <div class="external-event btn-success light" data-class="bg-success"><i class="fa fa-move"></i>Compra de instrumento</div>
                                        <div class="external-event btn-danger light" data-class="bg-danger"><i class="fa fa-move"></i>Venta Instrumento</div>
                                        <div class="external-event btn-info light" data-class="bg-info"><i class="fa fa-move"></i>Presenta Resultados</div>
                                        <div class="external-event btn-dark light" data-class="bg-dark"><i class="fa fa-move"></i>Pago Dividendo</div>
                                        <div class="external-event btn-secondary light" data-class="bg-secondary"><i class="fa fa-move"></i>Recordatorio Personal</div>
                                    </div>
                                    <!-- checkbox -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="card">
                            <div class="card-body">
                                <div id="calendar" class="app-fullcalendar"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

 <?php require_once ("footer.php");?>
    <script src="vendor/fullcalendar/js/main.min.js"></script>
	<script>
	(function ($) {
    "use strict"
	
	document.addEventListener('DOMContentLoaded', function() {


			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
			  headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay'
			  },
			  
			  editable: false,
			  droppable: false, // this allows things to be dropped onto the calendar
			  drop: function(arg) {
				// is the "remove after drop" checkbox checked?
				if (document.getElementById('drop-remove').checked) {
				  // if so, remove the element from the "Draggable Events" list
				  arg.draggedEl.parentNode.removeChild(arg.draggedEl);
				}
			  },
			  initialDate: '<?php echo date('Y-m-d'); ?>',
				  weekNumbers: true,
				  navLinks: true, // can click day/week names to navigate views
				  editable: false,
				  selectable: true,
				  nowIndicator: true,
			   events: [
				<?php 
$eventos = array();
$instrumentos = $cCalendario->getMovimentosInstrumentos($user->userData()['user_id']);
foreach ($instrumentos as $instrumento) {
    $calendar_instrumento = $instrumento['Wmovimientos_instrumento'];
    $calendar_fecha = $instrumento['Wmovimientos_fecha'];
    $evento = array(
        'title' => ($instrumento['Wmovimientos_operacion'] == "compra") ? 'Compra: '.$calendar_instrumento : 'Venta: '.$calendar_instrumento,
        'start' => $calendar_fecha,
        'url' => 'monedaDetalle?instrumento='.$calendar_instrumento,
        'className' => ($instrumento['Wmovimientos_operacion'] == "compra") ? 'bg-success' : 'bg-danger',
    );
    $eventos[] = $evento;
}

$wallets = $cCalendario->getMovimientosWallet($user->userData()['user_id']);
foreach ($wallets as $wallet) {
    $evento = array(
        'title' => $wallet['wallet_nombre'],
        'start' => substr($wallet['wallet_creado'], 0, 10),
        'url' => 'wallet?opc=wallet&objetivo='.$wallet['wallet_id'],
        'className' => 'bg-primary',
    );
    $eventos[] = $evento;
}

$calendarioGlobal = $cCalendario->getCalendarioGlobal();
foreach ($calendarioGlobal as $cGlobal) {
    $evento = array(
        'title' => $cGlobal['calendarioGlobal_instrumento'],
        'start' => $cGlobal['calendarioGlobal_fecha'],
        'url' => 'monedaDetalle?instrumento='.$cGlobal['calendarioGlobal_instrumento'],
        'className' => 'bg-secondary',
    );
    if ($cGlobal['calendarioGlobal_tipo'] == 'resultados') {
        $evento['className'] = 'bg-info';
    } elseif ($cGlobal['calendarioGlobal_tipo'] == 'dividendo') {
        $evento['className'] = 'bg-dark';
    }
    $eventos[] = $evento;
}

foreach ($eventos as $evento) {
    echo json_encode($evento).',';
}
?>

					{
					  title: 'Registro',
					  start: '<?php echo substr($user->userData()['user_registro'], 0, 10);?>',
					  className: "bg-warning"
					}
				  ]
			});
			calendar.render();

		  });
})(jQuery);</script>