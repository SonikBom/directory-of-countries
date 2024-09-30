<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/country' => [
            [['_route' => 'app_api_countryapp_api_country_root', '_controller' => 'App\\Controller\\CountryController::getAll'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_api_countryapp_api_country_add', '_controller' => 'App\\Controller\\CountryController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api' => [[['_route' => 'app_api_rootapp_api_root_index', '_controller' => 'App\\Controller\\RootController::index'], null, ['GET' => 0], null, true, false, null]],
        '/api/ping' => [[['_route' => 'app_api_rootapp_api_root_ping', '_controller' => 'App\\Controller\\RootController::ping'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/country/([^/]++)(?'
                    .'|(*:66)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        66 => [
            [['_route' => 'app_api_countryapp_api_country_code', '_controller' => 'App\\Controller\\CountryController::get'], ['code'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_api_countryapp_api_country_edit', '_controller' => 'App\\Controller\\CountryController::edit'], ['code'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'app_api_countryapp_api_airport_remove', '_controller' => 'App\\Controller\\CountryController::remove'], ['code'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
