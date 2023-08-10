<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jazztel</title>
    <meta name="description"
          content=""/>
    <meta name="keywords"
          content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<link rel="icon" type="image/x-icon" href="/favicon.ico"/>-->

    <!-- Styles -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="page-header-fixed">

<div class="container">
    <div class="text-center">
        <img src="./assets/static/jazztel.png" alt="">
    </div>
    <?php
    include 'db_includes.php';
    mysqli_report(MYSQLI_REPORT_STRICT);//Considera el warning como un error, y así tratar la excepción.

    date_default_timezone_set('America/Lima');
    ?>
    <div class="row">
        <div class="col-sm-12 mb-3">
            <a href="javascript:void(0)" onclick="showConfigs()" class="btn btn-primary float-end w-auto">Configuraciones</a>
        </div>
        <div class="col-sm-6">
            <div class="card border-info mb-3">
                <div class="card-header">Datos Server 1</div>
                <div class="card-body">
                    <?php
                    try {
                        $conexion1 = new mysqli($serverName1, $username1, $password1, $dbName1);
                        $consulta1 = "SELECT DISTINCT
                        -- DATE_FORMAT(a.fecha,'%Y/%m/%d') AS Fecha,
                        CASE 
                            when b.descripcion = 'BECALL_LIMA_1' then 'BECALL_LIMA_1 - Piso 5' 
                            when b.descripcion = 'BECALL_LIMA_2' then 'BECALL_LIMA_2 - SKR Piso 4' 
                            when b.descripcion = 'BECALL_LIMA_3' then 'BECALL_LIMA_3 - SKR Comas' 
                            when b.descripcion = 'BECALL_LIMA_4' then 'BECALL_LIMA_4 - Dialoga' 
                            when b.descripcion = 'BECALL_LIMA_5' then 'BECALL_LIMA_5 - AyOTelemarketing' 
                            when b.descripcion = 'BECALL_LIMA_6' then 'BECALL_LIMA_6 - Gestion Omnicanal' 
                            when b.descripcion = 'BECALL_LIMA_7' then 'BECALL_LIMA_7 - PowerConnecty' 
                            when b.descripcion = 'BECALL_LIMA_8' then 'BECALL_LIMA_8 - Dialoga/RyR' 
                            when b.descripcion = 'VERIFICACION_BECALL_LIMA' then 'VERIFICACION_LIMA_1 - Piso 5' 
                            when b.descripcion = 'VERIFICACION_BECALL_LIMA_2' then 'VERIFICACION_LIMA_2 - SKR Piso 4' 
                            when b.descripcion = 'VERIFICACION_BECALL_LIMA_3' then 'VERIFICACION_LIMA_3 - SKR Comas' 
                            when b.descripcion = 'VERIFICACION_BECALL_LIMA_4' then 'VERIFICACION_LIMA_4 - Dialoga' 
                            when b.descripcion = 'VERIFICACION_BECALL_LIMA_5' then 'VERIFICACION_LIMA_5 - AyOTelemarketing' 
                            when b.descripcion = 'VERIFICACION_BECALL_LIMA_6' then 'VERIFICACION_LIMA_6 - Gestion Omnicanal' 
                        END AS Campaign,
                        -- b.descripcion AS Campagnia,
                        COUNT(DISTINCT a.agent) AS 'Agentes Conectados'
                        FROM ocmdb.ocm_log_calls a
                        INNER JOIN ocmdb.ocm_campaign b
                        ON a.idcampaign=b.idcampaign
                        WHERE a.fecha >= '" . date('Y-m-d') . " 00:00:00' AND a.fecha <= '" . date('Y-m-d') . " 23:59:59' 
                        AND a.agent != ''
                        GROUP BY a.idcampaign
                        ORDER BY b.descripcion";
                        $resultados1 = $conexion1->query($consulta1);
                        if ($conexion1->connect_error) { ?>
                            <div class="alert alert-danger" role="alert">
                                Ha fallado la conexión: <?php echo $conexion1->connect_error ?>
                            </div>
                        <?php } else {
                            if ($resultados1->num_rows == 0) { ?>
                                <div class="alert alert-info" role="alert">
                                    No se encontraron datos para la fecha actual.
                                </div>
                            <?php } else {
                                while ($register = $resultados1->fetch_assoc()) {
                                    echo '<p class="card-text"><strong>Campaña: </strong> ' . $register['Campaign'] . '</p>';
                                    echo '<p class="card-text"><strong>Agentes Conectados: </strong>' . $register['Agentes Conectados'] . '</p>';
                                }
                            }
                        }
                    } catch (Exception $e) { ?>
                        <div class="alert alert-danger" role="alert">
                            Ha fallado la conexión: <?php echo $e->getMessage() ?>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card border-info mb-3">
                <div class="card-header">Datos Server 2</div>
                <div class="card-body">
                    <?php
                    try {
                        $conexion2 = new mysqli($serverName2, $username2, $password2, $dbName2);
                        $consulta2 = "SELECT DISTINCT
                        -- DATE_FORMAT(a.fecha,'%Y/%m/%d') AS Fecha,
                        b.descripcion AS Campaign,
                        COUNT(DISTINCT a.agent) AS 'Agentes Conectados'
                        FROM ocmdb.ocm_log_calls a
                        INNER JOIN ocmdb.ocm_campaign b
                        ON a.idcampaign=b.idcampaign
                        WHERE a.fecha >= '" . date('Y-m-d') . " 00:00:00' AND a.fecha <= '" . date('Y-m-d') . " 23:59:59' 
                        AND a.agent != '' AND b.descripcion LIKE '%Jazztel%'
                        GROUP BY a.idcampaign
                        ORDER BY b.descripcion";
                        $resultados2 = $conexion2->query($consulta2);
                        if ($conexion2->connect_error) { ?>
                            <div class="alert alert-danger" role="alert">
                                Ha fallado la conexión: <?php echo $conexion2->connect_error ?>
                            </div>
                        <?php } else {
                            if ($resultados2->num_rows == 0) { ?>
                                <div class="alert alert-info" role="alert">
                                    No se encontraron datos para la fecha actual.
                                </div>
                            <?php } else {
                                while ($register = $resultados2->fetch_assoc()) {
                                    echo '<p class="card-text"><strong>Campaña: </strong> ' . $register['Campaign'] . '</p>';
                                    echo '<p class="card-text"><strong>Agentes Conectados: </strong>' . $register['Agentes Conectados'] . '</p>';
                                }
                            }
                        }
                    } catch (Exception $e) { ?>
                        <div class="alert alert-danger" role="alert">
                            Ha fallado la conexión: <?php echo $e->getMessage() ?>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="configs">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Configuraciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="" class="form-label">Intervalo de refrescamiento:</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="intervalo"
                                       aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">segundos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveConfigs()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/plugins/jquery/jquery.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/gestionar-cookies.js"></script>
<script>
    let refresh_pause = false;
    $(document).ready(function () {
        if (docCookies.hasItem('intervalo_key')) {
            $('#intervalo').val(docCookies.getItem('intervalo_key'));
        } else {
            docCookies.setItem('intervalo_key', 30);
        }
        refreshPage();

        const modalConfigs = document.getElementById('configs')
        modalConfigs.addEventListener('hidden.bs.modal', event => {
            refresh_pause = false;
        })
    })

    function showConfigs() {
        refresh_pause = true;
        $('#intervalo').val(docCookies.getItem('intervalo_key'));
        $('#configs').modal('show');
    }

    function saveConfigs(){
        docCookies.setItem('intervalo_key', $('#intervalo').val());
        window.location.reload();
    }

    function refreshPage() {
        setTimeout(function () {
            if (!refresh_pause) {
                window.location.reload();
            }else{
                refreshPage();
            }
        }, docCookies.getItem('intervalo_key') * 1000)
    }
</script>
</body>
</html>