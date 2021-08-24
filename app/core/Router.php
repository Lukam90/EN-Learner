<?php

namespace app\core;

use app\core\Redirection;

use app\controllers\UsersController;
use app\controllers\ThemesController;
use app\controllers\ExpressionsController;

/**
 * Router Class
 */

abstract class Router {
    /* Parameters */

    /**
     * URL Initialization
     */

    public static function url() {
        $url = "/";

        if (Get::has("url")) {
            $url = rtrim(Get::var("url"), "/");
        }

        if (Post::has("url")) {
            $url = rtrim(Post::var("url"), "/");
        }

        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode("/", $url);

        return $url;
    }

    /**
     * Page Initialization
     */

    public static function page($url) {
        $page = "home";

        if (strlen($url[0]) > 0) {
            $page = $url[0];
        }

        return $page;
    }

    /**
     * Redirections
     */

    public static function init() {
        $url = self::url();
        $page = self::page($url);

        switch ($page) {
            case "home":
                Redirection::home();

                break;

            case "users":
                Redirection::users($url);

                break;
                
            case "themes":
                Redirection::themes($url);

                break;
            case "expressions":
                Redirection::expressions($url);

                break;
            case "tests":
                Redirection::tests();

                break;
            default:
                Redirection::notFound();

                break;
        }
    }
}