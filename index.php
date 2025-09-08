<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Servicio Social</title>
    <style>
        /* Fondo animado que garantiza visibilidad de los 4 colores */
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg,
                        #B8860B 20%,
                        #308A24 30%,
                        #2563EB 50%,
                        #800000 60%,
                        #B8860B 100%);
            background-size: 200% 200%;
            animation: gradientBG 12s ease infinite;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        @keyframes gradientBG {
            0%   { background-position: 0% 50%; }
            25%  { background-position: 50% 50%; }
            50%  { background-position: 100% 50%; }
            75%  { background-position: 50% 50%; }
            100% { background-position: 0% 50%; }
        }

        h1 {
            font-size: 2.2rem;
            margin: 0 0 18px 0;
            text-shadow: 0px 3px 6px rgba(0, 0, 0, 0.45);
        }

        .btn {
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px;
            transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease;
            color: white;
        }

        .btn:active { transform: translateY(1px); }

        .btn-info {
            background: #000000ff;
            box-shadow: 0 6px 14px rgba(8, 8, 8, 0.18);
        }
        .btn-info:hover {
            background: #6d1010ff;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.22);
        }

        .btn-login {
            background: #000000ff;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
        }
        .btn-login:hover {
            background: #0b920bff;
            box-shadow: 0 8px 18px rgba(5, 5, 5, 0.22);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.65);
        }

        .modal-content {
            background-color: #000000ff;
            color: #ffffffff;
            margin: 6% auto;
            padding: 20px 22px;
            border-radius: 10px;
            max-width: 760px;
            box-shadow: 0 8px 26px rgba(0,0,0,0.45);
            text-align: justify;
            border-top: 8px solid #308A24;
        }

        .close {
            color: #800000;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }
        .close:hover {
            color: #c00000;
        }

        .modal h2 {
            margin-top: 0;
            color: #308A24;
        }
        .modal h3 {
            color: #2563EB;
            margin-bottom: 6px;
        }

        .escudo {
            display: block;
            margin: 0 auto 15px auto;
            max-width: 150px;
        }

        @media (max-width: 600px) {
            .modal-content { margin: 12% 10px; padding: 16px; }
            h1 { font-size: 1.6rem; }
            .btn { width: 100%; max-width: 320px; }
        }
    </style>
</head>
<body>

    <h1>Proyecto de Servicio Social</h1>

    <div>
        <button class="btn btn-info" id="btnInfo">Ver Información del Proyecto</button>
        <button class="btn btn-login" onclick="window.location.href='iniciar_sesion.php'">Iniciar Sesión</button>
    </div>

    <div id="infoModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <span class="close" id="closeModal" aria-label="Cerrar">&times;</span>
            <img src="img/escudo_colegio.png" alt="Escudo del Colegio" class="escudo">
            <h2 id="modalTitle">¿Qué es el Servicio Social?</h2>
            <p>
                El Servicio Social Estudiantil Obligatorio es una actividad formativa que involucra a los estudiantes en proyectos 
                que beneficien a la comunidad, complementando la formación académica con experiencias prácticas de compromiso social, 
                responsabilidad y trabajo en equipo.
            </p>

            <h3>Marco Legal</h3>
            <p>
                Regulada por la <strong>Ley 115 de 1994</strong> (art. 97) y la <strong>Resolución 4210 de 1996</strong>, que establece 
                que los estudiantes de educación media deben realizar entre 80 y 120 horas de servicio social durante los grados 10° y 11°. 
                También la complementan el <strong>Acuerdo 55 de 2002</strong> y el <strong>Acuerdo 282 de 2007</strong>.
            </p>

            <h3>Propósito</h3>
            <p>
                Fomentar valores como solidaridad, respeto, participación ciudadana, protección ambiental y buen uso del tiempo libre, 
                además de fortalecer la identidad cultural y el compromiso social.
            </p>

            <h3>Historia</h3>
            <p>
                En Colombia, el Servicio Social se consolidó en el siglo XX como parte de políticas públicas para formar ciudadanos 
                responsables y participativos. Con el tiempo, se adaptó a las necesidades sociales y educativas, manteniendo su objetivo 
                de aportar al bienestar colectivo.
            </p>

            <h3>Actividades Comunes</h3>
            <p>
                - Proyectos ambientales (siembra de árboles, reciclaje, campañas de limpieza).<br>
                - Alfabetización y tutorías escolares.<br>
                - Apoyo a comunidades vulnerables y hogares de cuidado.<br>
                - Organización de eventos culturales y deportivos.<br>
                - Participación en campañas de salud y prevención.
            </p>

            <h3>Beneficios</h3>
            <p>
                - Desarrolla liderazgo y habilidades sociales.<br>
                - Fortalece el sentido de pertenencia.<br>
                - Permite aplicar conocimientos académicos en contextos reales.<br>
                - Fomenta el trabajo en equipo y la empatía.
            </p>
        </div>
    </div>

    <script>
        document.getElementById('btnInfo').addEventListener('click', function() {
            document.getElementById('infoModal').style.display = 'block';
            document.getElementById('closeModal').focus();
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('infoModal').style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            let modal = document.getElementById('infoModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                let modal = document.getElementById('infoModal');
                if (modal.style.display === 'block') modal.style.display = 'none';
            }
        });
    </script>

</body>
</html>
