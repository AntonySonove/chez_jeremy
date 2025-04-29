<?php
include "../view/view_header.php";
?>
<main>
        
    <div id="divTitle">
        <h1>Carte des services</h1>
    </div>


    <div id="forfaitsBarberMeeting">
        <div id="divServicesPrice">

            <div class="divServicesPrice">
                <h2>Coupe</h2>
                
                <div class="servicesPrice">
                    <p>Coupe + Coiffage Homme</p>
                    <p>25,00€</p>
                </div>
                <div class="separate"></div>
        
                <div class="servicesPrice">
                    <p>Dégradé américain<br>(à blanc)</p>
                    <p>25,00€</p>
                </div>
                <div class="separate"></div>
            
                <div class="servicesPrice">
                    <p>Coupe en brosse</p>
                    <p>25,00€</p>
                </div>
                <div class="separate"></div>
            
                <div class="servicesPrice">
                    <p>Coupe enfant<br>(-de 12 ans)</p>
                    <p>20,00€</p>
                </div>
            </div>
        
            
            <div id="forfaitsBarber">

                <div class="divServicesPrice">
                    <h2>Forfaits</h2>
                    
                    <div class="servicesPrice">
                        <p>Shampoing + Coupe + Coiffage</p>
                        <p>26,00€</p>
                    </div>
                    <div class="separate"></div>
            
                    <div class="servicesPrice">
                        <p>Coupe + coiffage + taille de barbe<br>(finition rasoir)</p>
                        <p>42,00€</p>
                    </div>
                </div>
        
                <div class="divServicesPrice">
                    <h2>Barber</h2>
                    
                    <div class="servicesPrice">
                        <p>Taille de barbe<br>(taillage et traçage au rasoir)</p>
                        <p>20,00€</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="imgButtonIndex">
            <img class="imgIndex imgIndexBrightness buttonServices" src="../src/pictures/meeting773.jpg" alt="prendre rendez-vous">
            <a class="buttonIndex" href="../controller/controller_appointment.php">Prendre rendez-vous</a>
        </div>
    </div>

</main>

<?php
include "../view/view_footer.php";