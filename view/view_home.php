<?php
class viewHome{

    public function displayView():string{

        return '
        
<main>
    <div class="shop">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tempor tempor feugiat. Curabitur ut mi ut lectus tristique eleifend. Donec auctor, lacus vel rutrum sagittis, lectus dui iaculis ex, ut consectetur dui nibh ac nunc. Morbi volutpat sapien nisl, ac hendrerit felis viverra a. Ut eu tempus nulla. Sed congue pellentesque augue sit amet bibendum. Integer ultricies interdum felis, vel placerat.</p>
    </div>

    <div id="imgButtonIndex">
        <div class="imgButtonIndex">
            <img class="imgIndex imgIndexBrightness" src="/repository/chez_jeremy/src/pictures/meeting773.jpg" alt="">
            <a class="buttonIndex" href="../controller/controller_appointment.php">Prendre rendez-vous</a>
        </div>
        <div class="imgButtonIndex">
            <img class="imgIndex imgIndexBrightness" src="/repository/chez_jeremy/src/pictures/services.jpg" alt="">
            <a class="buttonIndex" href="../../view/view_services.php">Carte des services</a>
        </div>
        <div class="imgButtonIndex">
            <img class="imgIndex imgIndexBrightness" src="/repository/chez_jeremy/src/pictures/products.jpg" alt="">
            <a class="buttonIndex" href="../view/view_products.php">Nos produits</a>
        </div>
    </div>
</main>
        ';
    }
}