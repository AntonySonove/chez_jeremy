<?php
//! Include des fichiers commun à chaque routes
include "./utils/utils.php";

//! Récupérer l'url entrée par l'utilisateur
$url=parse_url($_SERVER["REQUEST_URI"]);

//! Analyser l'intérieur de l'url pour récupérer le path (partie de l'url se trouvant après le nom de domaine)
isset($url["path"]) ? $path=$url["path"] : $path="/";

//! Comparer le path obtenu avec les routes mise en place

//* page d'acceuil


switch($path){
    case "/repository/chez_jeremy/":
        include "./controller/controller_header.php";
        include "./view/view_header.php";

        $header=new ControllerHeader(new ViewHeader);
        $header->render();

        include "./controller/controller_home.php";
        include "./view/view_home.php";

        $home=new ControllerHome(new ViewHome);
        $home->render();
        include "./view/view_footer.php";

        break;

    case "/repository/chez_jeremy/appointment":
        include "./controller/controller_header.php";
        include "./view/view_header.php";

        $header=new ControllerHeader(new ViewHeader);
        $header->render();

        include "./model/model_appointment.php";
        include "./controller/controller_appointment.php";
        include "./view/view_appointment.php";

        $appointment=new ControllerAppointment(new ViewAppointment,new ModelAppointment, );
        $appointment->render();
        include "./view/view_footer.php";

        break;
    
    case "/repository/chez_jeremy/services":
        include "./controller/controller_header.php";
        include "./view/view_header.php";

        $header=new ControllerHeader(new ViewHeader);
        $header->render();

        include "./controller/controller_services.php";
        include "./view/view_services.php";

        $services=new ControllerServices(new ViewServices);
        $services->render();

        include "./view/view_footer.php";

        break;

    case "/repository/chez_jeremy/products":
        include "./controller/controller_header.php";
        include "./view/view_header.php";

        $header=new ControllerHeader(new ViewHeader);
        $header->render();

        include "./controller/controller_products.php";
        include "./view/view_products.php";

        $products=new ControllerProducts(new ViewProducts);
        $products->render();

        include "./view/view_footer.php";

        break;
    }