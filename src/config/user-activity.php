<?php

return [
    'activated'        => true,
    'db_name'          => env('DB_DATABASE','laravel'),
    'tables_except'    => [
        'failed_jobs',
        'migrations',
        'password_reset_tokens',
        'password_resets',
        'personal_access_tokens',
        'user_activities'
    ],

    'events' => [
        'on_create'     => true,
        'on_update'     => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_logout'     => true,
        'on_lockout'    => true
    ],
    // https://github.com/jfcherng/php-diff
    'jfcherng_php_diff' => [
        // renderers: Combined, Inline, JsonHtml, SideBySide
        'rendererName' => 'Inline',
        'differOptions' => [
            // show how many neighbor lines
            // Differ::CONTEXT_ALL can be used to show the whole file
            'context' => 3,
            // ignore case difference
            'ignoreCase' => false,
            // ignore line ending difference
            'ignoreLineEnding' => false,
            // ignore whitespace difference
            'ignoreWhitespace' => false,
            // if the input sequence is too long, it will just gives up (especially for char-level diff)
            'lengthLimit' => 2000,
        ],
        'rendererOptions' => [
            // how detailed the rendered HTML in-line diff is? (none, line, word, char)
            'detailLevel' => 'line',
            // renderer language: eng, cht, chs, jpn, ...
            // or an array which has the same keys with a language file
            // check the "Custom Language" section in the readme for more advanced usage
            'language' => 'eng',
            // show line numbers in HTML renderers
            'lineNumbers' => true,
            // show a separator between different diff hunks in HTML renderers
            'separateBlock' => true,
            // show the (table) header
            'showHeader' => true,
            // the frontend HTML could use CSS "white-space: pre;" to visualize consecutive whitespaces
            // but if you want to visualize them in the backend with "&nbsp;", you can set this to true
            'spacesToNbsp' => false,
            // HTML renderer tab width (negative = do not convert into spaces)
            'tabSize' => 4,
            // this option is currently only for the Combined renderer.
            // it determines whether a replace-type block should be merged or not
            // depending on the content changed ratio, which values between 0 and 1.
            'mergeThreshold' => 0.8,
            // this option is currently only for the Unified and the Context renderers.
            // RendererConstant::CLI_COLOR_AUTO = -1 = colorize the output if possible (default)
            // RendererConstant::CLI_COLOR_ENABLE = 0 = force to colorize the output
            // RendererConstant::CLI_COLOR_DISABLE = 1 = force not to colorize the output
            'cliColorization' => -1,
            // this option is currently only for the Json renderer.
            // internally, ops (tags) are all int type but this is not good for human reading.
            // set this to "true" to convert them into string form before outputting.
            'outputTagAsString' => false,
            // this option is currently only for the Json renderer.
            // it controls how the output JSON is formatted.
            // see available options on https://www.php.net/manual/en/function.json-encode.php
            'jsonEncodeFlags' => \JSON_PRETTY_PRINT,
            // this option is currently effective when the "detailLevel" is "word"
            // characters listed in this array can be used to make diff segments into a whole
            // for example, making "<del>good</del>-<del>looking</del>" into "<del>good-looking</del>"
            // this should bring better readability but set this to empty array if you do not want it
            'wordGlues' => [' ', '-'],
            // change this value to a string as the returned diff if the two input strings are identical
            'resultForIdenticals' => null,
            // extra HTML classes added to the DOM of the diff container
            'wrapperClasses' => ['diff-wrapper'],
        ],
    ],
];
