var components = {
    "packages": [
        {
            "name": "ember",
            "main": "ember-built.js"
        },
        {
            "name": "handlebars",
            "main": "handlebars-built.js"
        },
        {
            "name": "jquery",
            "main": "jquery-built.js"
        }
    ],
    "shim": {
        "ember": {
            "exports": "Ember",
            "deps": [
                "jquery",
                "handlebars"
            ]
        },
        "handlebars": {
            "exports": "Handlebars"
        }
    },
    "baseUrl": "components"
};
if (typeof require !== "undefined" && require.config) {
    require.config(components);
} else {
    var require = components;
}
if (typeof exports !== "undefined" && typeof module !== "undefined") {
    module.exports = components;
}