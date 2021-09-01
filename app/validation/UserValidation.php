<?php

namespace app\validation;

use app\core\Post;

use app\models\User;

class UserValidation extends Validation {
    private $userModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->userModel = new User();
    }

    // Pseudo

    public function checkUsername() {
        $username = "";

        if (! Post::empty("username")) {
            $username = Post::var("username");

            $regex = "/^[a-z0-9\s]{2,32}$/i";
    
            if (preg_match($regex, $username)) {
                $exists = $this->userModel->findOneByName($username);
    
                if (! $exists) {
                    $this->erase("username");
                } else {
                    $this->setError("username", "Le pseudo existe déjà. Veuillez en choisir un autre.");
                }
            } else {
                $this->setError("username", "Le pseudo doit être valide.");
            }
        } else {
            $this->setError("username", "Le pseudo doit être renseigné.");
        }

        return $username;
    }

    // E-mail

    public function checkEmail() {
        $email = "";

        if (! Post::empty("email")) {
            $email = Post::var("email");

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $exists = $this->userModel->findOneByEmail($email);

                $this->erase("email");
    
                if ($exists) {
                    $this->setError("email", "Un compte existe déjà avec cette adresse e-mail. Veuillez en saisir une nouvelle.");
                }
            } else {
                $this->setError("email", "L'adresse e-mail doit être valide.");
            }
        } else {
            $this->setError("email", "L'adresse e-mail doit être renseignée.");
        }

        return $email;
    }

    // Mot de passe

    public function checkPassword() {
        $password = "";

        if (! Post::empty("password")) {
            $password = Post::var("password");

            $length = strlen($password);

            $hasLength = $length >= 8 && $length <= 32;

            if ($hasLength) {
                $hasLowerCase = preg_match("/[a-z]+/", $password);
                $hasUpperCase = preg_match("/[A-Z]+/", $password);
                $hasDigit = preg_match("/[0-9]+/", $password);

                $matches = $hasLowerCase && $hasUpperCase && $hasDigit;

                if ($matches) {
                    $this->erase("password");
                } else {
                    $this->setError("password", "Le mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre.");
                }
            } else {
                $this->setError("password", "Le mot de passe doit contenir entre 8 et 32 caractères.");
            }
        } else {
            $this->setError("password", "Le mot de passe doit être renseigné.");
        }

        return $password;
    }

    // Confirmation du mot de passe

    public function checkConfirm($password) {
        $confirm = "";

        if (! Post::empty("confirm")) {
            $confirm = Post::var("confirm");
    
            if ($confirm === $password) {
                $this->erase("confirm");
            } else {
                $this->setError("confirm", "Les mots de passe doivent correspondre.");
            }
        } else {
            $this->setError("confirm", "Le mot de passe doit être confirmé.");
        }

        return $confirm;
    }
}