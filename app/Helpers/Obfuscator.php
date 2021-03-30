<?php


namespace App\Helpers;


class Obfuscator {


    public static function getEmail($email)
    {
        $alwaysEncode = array('.', ':', '@');

        $result = '';

        // Encode string using oct and hex character codes
        for ($i = 0; $i < strlen($email); $i++) {
            // Encode 25% of characters including several that always should be encoded
            if (in_array($email[$i], $alwaysEncode) || mt_rand(1, 100) < 25) {
                if (mt_rand(0, 1)) {
                    $result .= '&#' . ord($email[$i]) . ';';
                } else {
                    $result .= '&#x' . dechex(ord($email[$i])) . ';';
                }
            } else {
                $result .= $email[$i];
            }
        }

        return $result;
    }

    public static function getEmailLink($email, $params = array())
    {
        if (!is_array($params)) {
            $params = array();
        }

        // Tell search engines to ignore obfuscated uri
        if (!isset($params['rel'])) {
            $params['rel'] = 'nofollow';
        }

        $neverEncode = array('.', '@', '+'); // Don't encode those as not fully supported by IE & Chrome

        $urlEncodedEmail = '';
        for ($i = 0; $i < strlen($email); $i++) {
            // Encode 25% of characters
            if (!in_array($email[$i], $neverEncode) && mt_rand(1, 100) < 25) {
                $charCode = ord($email[$i]);
                $urlEncodedEmail .= '%';
                $urlEncodedEmail .= dechex(($charCode >> 4) & 0xF);
                $urlEncodedEmail .= dechex($charCode & 0xF);
            } else {
                $urlEncodedEmail .= $email[$i];
            }
        }

        $obfuscatedEmail = self::getEmail($email);
        $obfuscatedEmailUrl = self::getEmail( 'mailto:' . $urlEncodedEmail);

        $link = '<a href="' . $obfuscatedEmailUrl . '"';
        foreach ($params as $param => $value) {
            $link .= ' ' . $param . '="' . htmlspecialchars($value). '"';
        }
        $link .= '>' . $obfuscatedEmail . '</a>';

        return $link;
    }

    /**
     * obfuscates a string
     * @param $value
     *
     * @return mixed|string
     */
    public static function getString($value) {
            $safe = '';

            foreach ( str_split( $value ) as $letter ) {
                if ( ord( $letter ) > 128 ) {
                    return $letter;
                }

                // To properly obfuscate the value, we will randomly convert each letter to
                // its entity or hexadecimal representation, keeping a bot from sniffing
                // the randomly obfuscated letters out of the string on the responses.
                switch ( rand( 1, 3 ) ) {
                    case 1:
                        $safe .= '&#' . ord( $letter ) . ';';
                        break;

                    case 2:
                        $safe .= '&#x' . dechex( ord( $letter ) ) . ';';
                        break;

                    case 3:
                        $safe .= $letter;
                }
            }

            return $safe;
    }


}
