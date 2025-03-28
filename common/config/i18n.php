<?php
return [
    'sourcePath' => '/private/var/www/osama/common',
    'languages' => ['ar-JO', 'en-US'], //Add languages to the array for the language files to be generated, here are English and Russian.
    'translator' => 'Yii::t',
    'sort' => false,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/vendor',
    ],
    'format' => 'php',
    'messagePath' => '/private/var/www/osama/common/messages', //path of messages folder created above
    'overwrite' => true,
];