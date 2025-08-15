<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Encuesta Seguimiento de Egresados</title>
	
	<!--favicon-->
	<link rel="shortcut icon" type="image/x-icon" href="{{url('img/logos/logoPVE-large.png')}}">
	
	 
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"> </script>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>





    <!--CSS-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
    <link rel="stylesheet" href="{{ asset('css/encuesta.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
	<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
	<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/themes/light.css" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
	
	
	@stack('css')
	
<!--tipografías-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Asegúrate de incluir el CSS de select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VTNFQFLGSY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VTNFQFLGSY');
</script>
<body>

@yield('content')
<!-- Popper.js (necesario para Tippy.js) -->

<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.min.js"></script>
<!--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mostrar/ocultar opciones
        window.toggleSelect = function (selectId) {
            const selectOptions = document.getElementById(selectId);
            if (selectOptions) {
                selectOptions.style.display = selectOptions.style.display === 'block' ? 'none' : 'block';
            }
        };

        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-select')) {
                document.querySelectorAll('.select-options').forEach(options => {
                    options.style.display = 'none';
                });
            }
        });

        // Inicializar opciones personalizadas
        document.querySelectorAll('.custom-select').forEach(select => {
            const selectOptions = select.querySelector('.select-options');
            const selectedValue = select.querySelector('.selected-value');

            select.querySelectorAll('.option-item').forEach(option => {
                option.addEventListener('click', () => {
                    selectedValue.textContent = option.textContent.trim();
                    selectOptions.style.display = 'none';
                });
            });
        });
    });
</script>
-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mostrar/ocultar opciones
        window.toggleSelect = function (selectId) {
            const selectOptions = document.getElementById(selectId);
            if (selectOptions) {
                selectOptions.style.display = selectOptions.style.display === 'block' ? 'none' : 'block';
            }
        };

        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-select')) {
                document.querySelectorAll('.select-options').forEach(options => {
                    options.style.display = 'none';
                });
            }
        });

        // Inicializar opciones personalizadas
        document.querySelectorAll('.custom-select').forEach(select => {
            const selectOptions = select.querySelector('.select-options');
            const selectedValue = select.querySelector('.selected-value');

            select.querySelectorAll('.option-item').forEach(option => {
                option.addEventListener('click', () => {
                    selectOptions.querySelectorAll('.option-item').forEach(opt => {
                        opt.classList.remove('selected');
                        opt.removeAttribute('style'); 
                    });

                    //Agregar la clase 'selected' al elemento seleccionado
                    option.classList.add('selected');|

                    //actualizar el texto seleccionado
                    selectedValue.textContent = option.textContent.trim();

                    //cerrar el menú
                    selectOptions.style.display = 'none';
                });
            });
        });

        // Inicializar Tippy.js
        tippy('[data-tippy-content]', {
            theme: 'custom',
            placement: 'top',
            animation: 'fade',
        });
    });

    
</script>
@stack('js')
</body>

<!--FOOTER-->
<footer>
	<div class="footer">

		<p class="texto6">
		© Copyright 2025 Universidad Nacional Autónoma de México.
		<br>
		Todos los derechos reservados.
		</p>

	</div>
</footer>
