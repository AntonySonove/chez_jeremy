<?php
// include "../view/view_header.php";
class ViewProducts{

    public function displayView():string{

        return'
        
        <main id="mainProducts">
        <div id="divTitleProducts">
            <h1>Nos produits</h1>
        </div>
        <div id="mansBeard">
            <img src="/repository/chez_jeremy/src/pictures/LOGO-OFFICIEL-NOIR-9-244x300.png" alt="logo Man\'s Beard" width="244" height="300">
            
            <div id="france">
                <div id="blue"></div><div id="white"></div><div id="red"></div>
            </div>
        </div>
        
        <div id="descriptionProducts">
            <h2>
                Des produits de qualité pour une expérience unique
            </h2>
            <p>
                Dans notre salon de coiffure, la qualité des prestations passe aussi par le choix des produits que nous utilisons au quotidien. C’est pourquoi nous avons fait le choix de collaborer avec Man’s Beard, une marque française reconnue pour son expertise dans les soins dédiés à la barbe, aux cheveux et à la peau.
            </p>
            <p>
                Man’s Beard, c’est avant tout une passion pour l’artisanat et le soin masculin. Depuis sa création en 2015, la marque s’est imposée comme une référence grâce à ses produits fabriqués en France, à base d’ingrédients soigneusement sélectionnés. Huiles à barbe, baumes, shampoings, soins capillaires ou encore lotions rafraîchissantes : chaque formule est pensée pour répondre aux besoins spécifiques des hommes modernes, soucieux de leur style et de leur bien-être.
            </p>
            <p>
                En choisissant les produits Man’s Beard, nous vous garantissons des soins efficaces, respectueux de votre peau et de vos cheveux, tout en valorisant le savoir-faire français. Que ce soit pour entretenir votre barbe, hydrater votre cuir chevelu ou sublimer votre coiffure, notre équipe utilise des produits haut de gamme pour un résultat à la hauteur de vos attentes.
            </p>
        </div>
    </main>
        ';
    }
}
    // include "../view/view_footer.php";