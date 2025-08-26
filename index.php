<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L&M Barber</title>
    <link rel="stylesheet" href="estilos.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- Link para utilizar pela Internet -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Link para utilizar no computador -->
    <link href="bootstrap533/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body style="background-color: var(--background);">
    
    <!-- Link para utilizar pela Internet -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
    <!-- Link para utilizar no computador -->
    <script src="bootstrap533/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
    <!-- Barbearia Corleone
    Barbones Barbearia -->

    <?php include_once('navbar.html'); ?>

    <a name="sobre"></a>
    <div class="row featurette" style="width: 100%; height: 500px; background-image: linear-gradient(rgba(0, 0, 0, 0.17), rgba(0, 0, 0, 0.17)), url('b.png');">
        <div class="col-md-5" style="background-color:rgb(25, 25, 25); margin-left: 120px;">
            <h1 class="featurette-heading fw-normal lh-1" style="overflow-y: hidden; font-size: 50px; color: aliceblue; font-family: 'Merriweather', serif;"><br><br><br>A MELHOR DA <br>
                <span class="text-body-secondary" style="color: var(--accent) !important; font-family: 'Playfair Display', serif !important;">CIDADE<p></p><p></p></span>
            </h1>
            <p class="lead" style="color: white; font-family: 'Raleway', sans-serif;">"A L&M Barber é um espaço moderno que oferece cortes, barba e cuidados masculinos com qualidade e estilo."</p>
        </div>
        <div class="col-md-5">
            <!-- <svg aria-label="Placeholder: 500x500" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" height="500" preserveAspectRatio="xMidYMid slice" role="img" width="500" xmlns="http://www.w3.org/2000/svg">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-bg)">
                </rect>
                <text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
            </svg> -->
        </div>
    </div>

    <div class="row featurette" style="width: 100%; height: 500px; background-image: url('c.png');">
        <div class="col-md-5">
            <!-- <svg aria-label="Placeholder: 500x500" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" height="500" preserveAspectRatio="xMidYMid slice" role="img" width="500" xmlns="http://www.w3.org/2000/svg">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-bg)">
                </rect>
                <text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
            </svg> -->
        </div>
        <div class="col-md-5" style="background-color:rgb(25, 25, 25); margin-left: 120px;">
            <h1 class="featurette-heading fw-normal lh-1" style="overflow-y: hidden; font-size: 50px; color: aliceblue; font-family: 'Merriweather', serif;"><br><br><br>QUALIDADE <br>
                <span class="text-body-secondary" style="color:var(--accent) !important; font-family: 'Playfair Display', serif;">INIGUALÁVEL<p></p><p></p></span>
            </h1>
            <p class="lead" style="color: white; font-family: 'Raleway', sans-serif;">"Transforme seu visual com cortes precisos e um atendimento exclusivo. Seu estilo, nossa prioridade."</p>
        </div>
    </div>

    <hr class="featurette-divider">
    <hr class="featurette-divider">

    <hr style="width: 85%;" />

    <hr class="featurette-divider">

    <a name="servicos"></a>
    <?php include_once('card1.html'); ?>

    <hr style="width: 85%;" />
    
    <hr class="featurette-divider">
    <hr class="featurette-divider">

    <a name="agendamento"></a>
    <?php include_once('place.html'); ?>

    <hr class="featurette-divider">
    <hr class="featurette-divider">

    <button id="subiiiuuuuu" onclick="scrollar()">Voltar ao topo</button>

    <?php include_once('footer.html'); ?>

    <script src="script.js"></script>

</body>
</html>
