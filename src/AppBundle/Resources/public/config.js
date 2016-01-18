(function () {
    'use strict';

    var config = window.require ? window.require : {};
    config = {
        'paths': config.paths,

        'waitSeconds': 30,
        'urlArgs':     'bust=' + window.$assets_version,
        "baseUrl": "/assets/js",

        "map":    {
            /*            "*":                   {
             "twig":                  "config/twig",
             },
             "config/twig":         {
             "twig": "twig",
             },
             "config/iwin-twitter": {
             "social/module.twitter": "social/module.twitter",
             },*/

        },

        "shim": {
            "jquery.elastic": {
                deps: ["jquery"]
            },
        },

        "config": {
            /*"social/api.google-loader":   window.$socials.google,*/
        },
    };

    require.config(config)
}());