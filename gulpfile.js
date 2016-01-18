(function () {
    'use strict';

    process.env.NODE_MAX_LISTENER = 500;
    require('./vendor/werkint/frontend-mapper-bundle/src/Resources/gulp/index.js')();
})();
