<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CCookie
 *
 * @author Admin
 */
class CCookie
{
    /**
     * Sets a cookie based on vBulletin environmental settings
     *
     * @param    string    Cookie name
     * @param    mixed    Value to store in the cookie
     * @param    boolean    If true, do not set an expiry date for the cookie
     * @param    boolean    Allow secure cookies (SSL)
     * @param    boolean    Set 'httponly' for cookies in supported browsers
     */
    public static function vbsetcookie($name, $value = '', $permanent = true, $allowsecure = true, $httponly = false)
    {
        if (!defined('COOKIE_PREFIX')) {
            define('COOKIE_PREFIX', 'vgvs_');
        }

        if ($permanent) {
            $expire = TIMENOW + 60 * 60 * 24 * 365;
        }
        else {
            $expire = 0;
        }

        // IE for Mac doesn't support httponly
        $httponly = (($httponly AND (self::is_browser('ie') AND self::is_browser('mac'))) ? false : $httponly);

        // check for SSL
        $secure = ((REQ_PROTOCOL === 'https' AND $allowsecure) ? true : false);

        $name = COOKIE_PREFIX . $name;

        $filename = 'N/A';
        $linenum = 0;

        if (!headers_sent($filename, $linenum)) { // consider showing an error message if they're not sent using above variables?
            if ($value === '' OR $value === false) {
                // this will attempt to unset the cookie at each directory up the path.
                // ie, path to file = /test/vb3/. These will be unset: /, /test, /test/, /test/vb3, /test/vb3/
                // This should hopefully prevent cookie conflicts when the cookie path is changed.

                if (isset($_SERVER['PATH_INFO']) OR isset($_ENV['PATH_INFO'])) {
                    $scriptpath = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_ENV['PATH_INFO'];
                }
                else if ($_SERVER['REDIRECT_URL'] OR $_ENV['REDIRECT_URL']) {
                    $scriptpath = $_SERVER['REDIRECT_URL'] ? $_SERVER['REDIRECT_URL'] : $_ENV['REDIRECT_URL'];
                }
                else {
                    $scriptpath = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_ENV['PHP_SELF'];
                }

                $scriptpath = preg_replace(
                        array(
                    '#/[^/]+\.php$#i',
                    '#/(' . preg_quote('admincp', '#') . '|' . preg_quote('modcp', '#') . ')(/|$)#i'
                        ), '', $scriptpath
                );

                $dirarray = explode('/', preg_replace('#/+$#', '', $scriptpath));

                $alldirs = '';
                $havepath = false;
                if (!defined('SKIP_AGGRESSIVE_LOGOUT')) {
                    // sending this many headers has caused problems with a few
                    // servers, especially with IIS. Defining SKIP_AGGRESSIVE_LOGOUT
                    // reduces the number of cookie headers returned.
                    foreach ($dirarray AS $thisdir) {
                        $alldirs .= "$thisdir";

                        if ($alldirs == '/' OR "$alldirs/" == '/') {
                            $havepath = true;
                        }

                        if (!empty($thisdir)) {
                            // try unsetting without the / at the end
                            self::exec_vbsetcookie($name, $value, $expire, $alldirs, DOMAIN, $secure, $httponly);
                        }

                        $alldirs .= "/";
                        self::exec_vbsetcookie($name, $value, $expire, $alldirs, DOMAIN, $secure, $httponly);
                    }
                }

                if ($havepath == false) {
                    self::exec_vbsetcookie($name, $value, $expire, '/', DOMAIN, $secure, $httponly);
                }
            }
            else {
                self::exec_vbsetcookie($name, $value, $expire, '/', DOMAIN, $secure, $httponly);
            }
        }
    }
// #############################################################################
    /**
     * Calls PHP's setcookie() or sends raw headers if 'httponly' is required.
     * Should really only be called through vbsetcookie()
     *
     * @param    string    Name
     * @param    string    Value
     * @param    int        Expire
     * @param    string    Path
     * @param    string    Domain
     * @param    boolean    Secure
     * @param    boolean    HTTP only - see http://msdn.microsoft.com/workshop/author/dhtml/httponly_cookies.asp
     *
     * @return    boolean    True on success
     */
    private static function exec_vbsetcookie($name, $value, $expires, $path = '', $domain = '', $secure = false, $httponly = false)
    {
        if ($httponly AND $value) {
            // cookie names and values may not contain any of the characters listed
            foreach (array(",", ";", " ", "\t", "\r", "\n", "\013", "\014") AS $bad_char) {
                if (strpos($name, $bad_char) !== false OR strpos($value, $bad_char) !== false) {
                    return false;
                }
            }

            // name and value
            $cookie = "Set-Cookie: $name=" . urlencode($value);

            // expiry
            $cookie .= ($expires > 0 ? '; expires=' . gmdate('D, d-M-Y H:i:s', $expires) . ' GMT' : '');

            // path
            $cookie .= ($path ? "; path=$path" : '');

            // domain
            $cookie .= ($domain ? "; domain=$domain" : '');

            // secure
            $cookie .= ($secure ? '; secure' : '');

            // httponly
            $cookie .= ($httponly ? '; HttpOnly' : '');

            header($cookie, false);
            return true;
        }
        else {
            return setcookie($name, $value, $expires, $path, $domain, $secure);
        }
    }
// #############################################################################
    /**
     * Browser detection system - returns whether or not the visiting browser is the one specified
     *
     * @param    string    Browser name (opera, ie, mozilla, firebord, firefox... etc. - see $is array)
     * @param    float    Minimum acceptable version for true result (optional)
     *
     * @return    boolean
     */
    private static function is_browser($browser, $version = 0)
    {
        static $is;
        if (!is_array($is)) {
            $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $is = array(
                'opera' => 0,
                'ie' => 0,
                'mozilla' => 0,
                'firebird' => 0,
                'firefox' => 0,
                'camino' => 0,
                'konqueror' => 0,
                'safari' => 0,
                'webkit' => 0,
                'webtv' => 0,
                'netscape' => 0,
                'mac' => 0,
                'ie64bit' => 0,
            );

            // detect opera
            # Opera/7.11 (Windows NT 5.1; U) [en]
            # Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.0) Opera 7.02 Bork-edition [en]
            # Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 4.0) Opera 7.0 [en]
            # Mozilla/4.0 (compatible; MSIE 5.0; Windows 2000) Opera 6.0 [en]
            # Mozilla/4.0 (compatible; MSIE 5.0; Mac_PowerPC) Opera 5.0 [en]
            if (strpos($useragent, 'opera') !== false) {
                preg_match('#opera(/| )([0-9\.]+)#', $useragent, $regs);
                $is['opera'] = $regs[2];
            }

            // detect internet explorer
            # Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Q312461)
            # Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.0.3705)
            # Mozilla/4.0 (compatible; MSIE 5.22; Mac_PowerPC)
            # Mozilla/4.0 (compatible; MSIE 5.0; Mac_PowerPC; e504460WanadooNL)
            if (strpos($useragent, 'msie ') !== false AND !$is['opera']) {
                preg_match('#msie ([0-9\.]+)#', $useragent, $regs);
                $is['ie'] = $regs[1];
                if (strpos($useragent, 'x64') !== false) {
                    $is['ie64bit'] = 1;
                }
            }

            // detect macintosh
            if (strpos($useragent, 'mac') !== false) {
                $is['mac'] = 1;
            }

            // detect safari
            # Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/74 (KHTML, like Gecko) Safari/74
            # Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/51 (like Gecko) Safari/51
            # Mozilla/5.0 (Windows; U; Windows NT 6.0; en) AppleWebKit/522.11.3 (KHTML, like Gecko) Version/3.0 Safari/522.11.3
            # Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1C28 Safari/419.3
            # Mozilla/5.0 (iPod; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3A100a Safari/419.3
            if (strpos($useragent, 'applewebkit') !== false) {
                preg_match('#applewebkit/([0-9\.]+)#', $useragent, $regs);
                $is['webkit'] = $regs[1];

                if (strpos($useragent, 'safari') !== false) {
                    preg_match('#safari/([0-9\.]+)#', $useragent, $regs);
                    $is['safari'] = $regs[1];
                }
            }

            // detect konqueror
            # Mozilla/5.0 (compatible; Konqueror/3.1; Linux; X11; i686)
            # Mozilla/5.0 (compatible; Konqueror/3.1; Linux 2.4.19-32mdkenterprise; X11; i686; ar, en_US)
            # Mozilla/5.0 (compatible; Konqueror/2.1.1; X11)
            if (strpos($useragent, 'konqueror') !== false) {
                preg_match('#konqueror/([0-9\.-]+)#', $useragent, $regs);
                $is['konqueror'] = $regs[1];
            }

            // detect mozilla
            # Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.4b) Gecko/20030504 Mozilla
            # Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.2a) Gecko/20020910
            # Mozilla/5.0 (X11; U; Linux 2.4.3-20mdk i586; en-US; rv:0.9.1) Gecko/20010611
            if (strpos($useragent, 'gecko') !== false AND !$is['safari'] AND !$is['konqueror']) {
                // See bug #26926, this is for Gecko based products without a build
                $is['mozilla'] = 20090105;
                if (preg_match('#gecko/(\d+)#', $useragent, $regs)) {
                    $is['mozilla'] = $regs[1];
                }

                // detect firebird / firefox
                # Mozilla/5.0 (Windows; U; WinNT4.0; en-US; rv:1.3a) Gecko/20021207 Phoenix/0.5
                # Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6
                # Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4a) Gecko/20030423 Firebird Browser/0.6
                # Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.6) Gecko/20040206 Firefox/0.8
                if (strpos($useragent, 'firefox') !== false OR strpos($useragent, 'firebird') !== false OR strpos($useragent, 'phoenix') !== false) {
                    preg_match('#(phoenix|firebird|firefox)( browser)?/([0-9\.]+)#', $useragent, $regs);
                    $is['firebird'] = $regs[3];

                    if ($regs[1] == 'firefox') {
                        $is['firefox'] = $regs[3];
                    }
                }

                // detect camino
                # Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-US; rv:1.0.1) Gecko/20021104 Chimera/0.6
                if (strpos($useragent, 'chimera') !== false OR strpos($useragent, 'camino') !== false) {
                    preg_match('#(chimera|camino)/([0-9\.]+)#', $useragent, $regs);
                    $is['camino'] = $regs[2];
                }
            }

            // detect web tv
            if (strpos($useragent, 'webtv') !== false) {
                preg_match('#webtv/([0-9\.]+)#', $useragent, $regs);
                $is['webtv'] = $regs[1];
            }

            // detect pre-gecko netscape
            if (preg_match('#mozilla/([1-4]{1})\.([0-9]{2}|[1-8]{1})#', $useragent, $regs)) {
                $is['netscape'] = "$regs[1].$regs[2]";
            }
        }

        // sanitize the incoming browser name
        $browser = strtolower($browser);
        if (substr($browser, 0, 3) == 'is_') {
            $browser = substr($browser, 3);
        }

        // return the version number of the detected browser if it is the same as $browser
        if ($is["$browser"]) {
            // $version was specified - only return version number if detected version is >= to specified $version
            if ($version) {
                if ($is["$browser"] >= $version) {
                    return $is["$browser"];
                }
            }
            else {
                return $is["$browser"];
            }
        }

        // if we got this far, we are not the specified browser, or the version number is too low
        return 0;
    }
}
?>
