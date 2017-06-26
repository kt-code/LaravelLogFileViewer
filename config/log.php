<?php
return [

    'dir_path' => rtrim(env('LOG_DIR_PATH', '/var/log/nginx'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR,

    'default_file' => ltrim(env('LOG_DEFAULT_FILE', 'filename.log'), DIRECTORY_SEPARATOR),

];