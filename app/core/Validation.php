<?php

namespace app\core;

abstract class Validation {
    // Indications

    const TIP_USERNAME = "Le pseudo doit faire entre 2 et 32 caractères alphanumériques (espaces inclus).";
    
    const TIP_EMAIL = "L'adresse e-mail doit être valide et peut comporter jusqu'à 100 caractères.";
    
    const TIP_PASSWORD = "Le mot de passe doit comporter 8 à 32 caractères alphanumériques, avec au moins une minuscule, une majuscule et un chiffre.";

    // 
}