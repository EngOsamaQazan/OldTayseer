<?php

namespace api\helpers;

use Yii;

class Security {

    public static function cleanInput($input) {
        $search = array(
            '@<script[^>]*?>.*?</script>@si', //Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );
        $input = trim($input);
        $output = preg_replace($search, '', $input);
        return $output;
    }

    public static function sanitize($input) {
        $output = [];
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = self::sanitize($val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input = self::cleanInput($input);
            $output = ($input); //mysql_real_escape_string($input); //\Yii::$app->db->quoteValue($inp
        }
        return $output;
    }

}
