<?php

namespace app\controllers;

use app\models\User;
use app\models\Theme;
use app\models\Expression;

use app\controllers\Controller;

class UsersController extends Controller {
    private $userModel;
    private $themeModel;
    private $expressionModel;

    // Constructeur

    public function __construct() {
        $this->init();

        $this->userModel = new User();
        $this->themeModel = new Theme();
        $this->expressionModel = new Expression();
    }

    // Liste des utilisateurs

    public function index() {
        // Données

        $list = $this->userModel->findAll();

        $users = [];

        $index = 0;

        foreach ($list as $user) {
            // Lecture

            $userId = $user->id;
            $username = $user->username;
            $role = $user->role;

            $createdAt = new \DateTime($user->created_at);
            $createdAt = $createdAt->format("d/m/Y");

            $nbThemes = $this->themeModel->countByUser($userId);
            $nbExpressions = $this->expressionModel->countByUser($userId);

            // Couleur / Rôle

            $color = "";

            if ($role == "Administrateur") {
                $color = "w3-text-red";
            } else if ($role == "Modérateur") {
                $color = "w3-text-green";
            }

            // Enregistrement

            $users[$index]["id"] = $userId;
            $users[$index]["username"] = $username;
            $users[$index]["role"] = $role;
            $users[$index]["color"] = $color;
            $users[$index]["createdAt"] = $createdAt;
            $users[$index]["nbThemes"] = $nbThemes;
            $users[$index]["nbExpressions"] = $nbExpressions;

            $index++;
        }

        // Rendu

        echo $this->twig->render("users.twig", [
            "users" => $users
        ]);
    }

    // Profil d'un utilisateur

    public function profile() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/profile.twig", [
            "username" => "Lukas"
        ]);
    }

    // Inscription d'un utilisateur

    public function register() {
        // 

        // Rendu

        echo $this->twig->render("users/register.twig", [
            "key" => "value"
        ]);
    }

    // Connexion d'un utilisateur

    public function login() {
        // 

        // Rendu

        echo $this->twig->render("users/login.twig", [
            "key" => "value"
        ]);
    }

    // Edition d'un utilisateur

    public function edit() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/edit_user.twig", [
            "username" => "Lukas"
        ]);
    }

    // Suppression d'un utilisateur

    public function delete() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/delete_user.twig", [
            "username" => "Lukas"
        ]);
    }

    // Demande de nouveau mot de passe

    public function reset() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/reset.twig", [
            "key" => "value"
        ]);
    }

    // Confirmation du nouveau mot de passe

    public function confirm() {
        // Connexion

        // Rendu

        echo $this->twig->render("users/confirm.twig", [
            "key" => "value"
        ]);
    }
}