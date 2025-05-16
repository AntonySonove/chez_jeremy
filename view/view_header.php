<?php
class ViewHeader{
    private? string $message;

    public function getMessage(): string { return $this->message; }
    public function setMessage(string $message): self { $this->message = $message; return $this; }

    public function displayView():string{

        return '
        
<!DOCTYPE html>
<html lang="fr">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chez JEREMY - Accueil</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="/repository/chez_jeremy/src/style/header.css">
    <link rel="stylesheet" href="/repository/chez_jeremy/src/style/footer.css">
    <link rel="stylesheet" href="/repository/chez_jeremy/src/style/products.css">
    <link rel="stylesheet" href="/repository/chez_jeremy/src/style/services.css">
    <link rel="stylesheet" href="/repository/chez_jeremy/src/style/style.css">
    <link rel="stylesheet" href="/repository/chez_jeremy/src/style/index.css">
    <link rel="stylesheet" href="/repository/chez_jeremy/src/style/appointment.css">
</head>
<body>
    <header>
        <a id="logo" href="/repository/chez_jeremy/"><img src="/repository/chez_jeremy/src/pictures/logo.PNG" alt="logo" width="189" height="85"></a>
        <div id="burgerMenuButton">
            <div class="burgerMenu"></div>
            <div class="burgerMenu"></div>
            <div class="burgerMenu"></div>
        </div>
        <div id="dropdownHeader" class="hideDropdown">
            <a href="/repository/chez_jeremy/appointment">Prendre rendez-vous</a>
            <a href="/repository/chez_jeremy/services">Carte des Services</a>
            <a href="/repository/chez_jeremy/products">Nos produits</a>
            <a href="#contact">Contact</a>
        </div>
        <div id="nav">
            <a href="/repository/chez_jeremy/appointment">Prendre rendez-vous</a>
            <a href="/repository/chez_jeremy/services">Carte des Services</a>
            <a href="/repository/chez_jeremy/products">Nos produits</a>
            <a href="#contact">Contact</a>
            
        </div>
    </header>
        
        ';
    }
}

