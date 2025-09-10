<?php error_reporting(E_ALL); ini_set('display_errors','1'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio Social</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9f7;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: #308A24;
            color: white;
            padding: 80px 20px;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
            gap: 20px;
            flex-wrap: wrap;
        }

        .header-text {
            text-align: center;
            flex: 1;
            min-width: 280px;
        }

        .header-text h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
        }

        .header-text p {
            font-size: 1.2rem;
        }

        .btn-login {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 28px;
            background: white;
            color: #308A24;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .btn-login:hover {
            background: #256f1a;
            color: white;
        }

        .header-img {
            flex: 1;
            display: flex;
            justify-content: center;
            min-width: 200px;
        }

        .header-img img {
            max-width: 250px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .header-img {
                display: none; /* Oculta imágenes en móvil y tablet */
            }

            .header-text h1 {
                font-size: 2rem;
            }

            .header-text p {
                font-size: 1rem;
            }
        }

        section {
            padding: 60px 20px;
            max-width: 1100px;
            margin: auto;
        }

        section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #308A24;
        }

        section p {
            text-align: justify;
            margin-bottom: 20px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .feature {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .feature i {
            font-size: 2rem;
            color: #308A24;
            margin-bottom: 10px;
        }

        .testimonios {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .testimonio {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            font-style: italic;
            transition: all 0.3s ease;
        }

        .testimonio:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        .testimonio strong {
            display: block;
            margin-top: 10px;
            text-align: right;
            font-style: normal;
            color: #308A24;
        }

        .galeria {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }

        .galeria img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            object-fit: cover;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .galeria img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 14px rgba(0,0,0,0.3);
        }

        footer {
            background: #308A24;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="header-container">
            <!-- Imagen izquierda -->
            <div class="header-img">
                <img src="img/escudo_colegio.png" alt="Imagen izquierda">
            </div>

            <!-- Texto central -->
            <div class="header-text">
                <h1>Servicio Social Estudiantil</h1>
                <p>Compromiso, solidaridad y formación integral para los jóvenes de Colombia.</p>
                <a href="iniciar_sesion.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
            </div>

            <!-- Imagen derecha -->
            <div class="header-img">
                <img src="img/servicio-social.png" alt="Imagen derecha">
            </div>
        </div>
    </header>

    <!-- Info -->
    <section>
        <h2>¿Qué es el Servicio Social?</h2>
        <p>
            El <strong>Servicio Social Estudiantil Obligatorio</strong> es una actividad formativa regulada en Colombia
            por la <b>Ley 115 de 1994</b> y la <b>Resolución 4210 de 1996</b>.  
            Los estudiantes de educación media deben realizar entre 80 y 120 horas de servicio social durante los grados 10° y 11°.  
            Su propósito es vincular a los jóvenes en actividades que beneficien a la comunidad, promoviendo valores como solidaridad,
            responsabilidad, respeto y participación ciudadana.
        </p>

        <div class="features">
            <div class="feature">
                <i class="fas fa-leaf"></i>
                <h3>Medio Ambiente</h3>
                <p>Campañas de reciclaje, reforestación y cuidado de espacios naturales.</p>
            </div>
            <div class="feature">
                <i class="fas fa-book"></i>
                <h3>Educación</h3>
                <p>Tutorías, apoyo en alfabetización y acompañamiento a estudiantes más pequeños.</p>
            </div>
            <div class="feature">
                <i class="fas fa-hand-holding-heart"></i>
                <h3>Solidaridad</h3>
                <p>Ayuda en hogares comunitarios, campañas de salud y apoyo a poblaciones vulnerables.</p>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section>
        <h2>Testimonios</h2>
        <div class="testimonios">
            <div class="testimonio">
                "El servicio social me enseñó a trabajar en equipo y valorar las necesidades de los demás."
                <strong>- Ana María, 11°</strong>
            </div>
            <div class="testimonio">
                "Aprendí que pequeños gestos pueden transformar la vida de una persona."
                <strong>- Carlos, 10°</strong>
            </div>
            <div class="testimonio">
                "Me siento orgulloso de aportar a mi colegio y comunidad."
                <strong>- Laura, 11°</strong>
            </div>
        </div>
    </section>

    <!-- Galería -->
    <section>
        <h2>Galería de Actividades</h2>
        <div class="galeria">
            <img src="img/banda.jpeg" alt="Actividad de reforestación">
            <img src="img/servicio.jpeg" alt="Tutoría escolar">
            <img src="img/pintura.jpg" alt="Campaña de limpieza">
            <img src="img/entrada.jpg" alt="Actividad comunitaria">
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Colegio San José de Guanentá - Servicio Social</p>
    </footer>

</body>
</html>
