<?php

/**
 * This file contains constants and shortcut functions that are commonly used.
 * Please only include functions are most widely used because this file
 * is included for every request. Functions are less often used are better
 * encapsulated as static methods in helper classes that are loaded on demand.
 */
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()->clientScript->registerCssFile
 */
function regCssFile($files, $url = 'css', $addBaseUrl = true) {
    if (!is_array($files))
        $files = array($files);
    foreach ($files as $file) {
        $file = ($addBaseUrl) ? bu($url) . '/' . $file . '.css' : $url . '/' . $file . '.css';
        cs()->registerCssFile($file);
    }
}

/**
 * This is the shotcut to Yii::app()->clientScript->registerCoreScript
 */
function regCoreFile($files) {
    if (!is_array($files))
        $files = array($files);
    foreach ($files as $file)
        cs()->registerCoreScript($file);
}

/**
 * This is the shortcut to Yii::app()->clientScript->registerScriptFile
 */
function regJsFile($files, $url = 'js', $pos = CClientScript::POS_HEAD) {
    if (!is_array($files))
        $files = array($files);
    foreach ($files as $file)
        cs()->registerScriptFile(bu($url) . '/' . $file . '.js', $pos);
}

/**
 * Shortcut to display Icon image
 * @param string $img image file
 * @param string $size
 * @param string $options
 */
function icon($img, $size = '48', $options = array()) {
    return img(bu('/images/icons/' . $size . '/' . $img), '', $size, null, $options);
}

/**
 * Displays a variable.
 * This method achieves the similar functionality as var_dump and print_r
 * but is more robust when handling complex objects such as Yii controllers.
 * @param mixed variable to be dumped
 * @param integer maximum depth that the dumper should go into the variable. Defaults to 10.
 * @param boolean whether the result should be syntax-highlighted
 */
function dump($target, $depth = 10, $highlight = true) {
    echo CVarDumper::dumpAsString($target, $depth, $highlight);
}

/**
 * This is the shortcut to CHtml::encode
 */
function h($text, $limit = 0) {
    if ($limit && strlen($text) > $limit && ($pos = strrpos(substr($text, 0, $limit), ' ')) !== false)
        $text = substr($text, 0, $pos) . ' ...';
    return htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset);
}

/**
 * This is the shortcut to nl2br(CHtml::encode())
 * @param string the text to be formatted
 * @param integer the maximum length of the text to be returned. If 0, it means no truncation.
 * @param string the label of the "read more" button if $limit is greater than 0.
 * Set this to be false if the "read more" button should not be displayed.
 * @return string the formatted text
 */
function nh($text, $limit = 0, $readMore = 'read more') {
    if ($limit && strlen($text) > $limit) {
        if (($pos = strpos($text, ' ', $limit)) !== false)
            $limit = $pos;
        $ltext = substr($text, 0, $limit);
        if ($readMore !== false) {
            $rtext = substr($text, $limit);
            return nl2br(htmlspecialchars($ltext, ENT_QUOTES, Yii::app()->charset))
                    . ' ' . l(h($readMore), '#', array('class' => 'read-more', 'onclick' => '$(this).hide().next().show(); return false;'))
                    . '<span style="display:none;">'
                    . nl2br(htmlspecialchars($rtext, ENT_QUOTES, Yii::app()->charset))
                    . '</span>';
        }
        else
            return nl2br(htmlspecialchars($ltext . ' ...', ENT_QUOTES, Yii::app()->charset));
    }
    else
        return nl2br(htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset));
}

/**
 * This is the shortcut to CHtmlPurifier::purify().
 */
function ph($text) {
    static $purifier;
    if ($purifier === null)
        $purifier = new CHtmlPurifier;
    return $purifier->purify($text);
}

/**
 * Converts a markdown text into purified HTML
 */
function mh($text) {
    static $parser;
    if ($parser === null)
        $parser = new MarkdownParser;
    return $parser->safeTransform($text);
}

/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array()) {
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * Generates an image tag.
 * @param string $url the image URL
 * @param string $alt the alt text for the image. Images should have the alt attribute, so at least an empty one is rendered.
 * @param integer the width of the image. If null, the width attribute will not be rendered.
 * @param integer the height of the image. If null, the height attribute will not be rendered.
 * @param array additional HTML attributes (see {@link tag}).
 * @return string the generated image tag
 */
function img($url, $alt = '', $width = null, $height = null, $htmlOptions = array()) {
    $htmlOptions['src'] = $url;
    if ($alt !== null)
        $htmlOptions['alt'] = $alt;
    else
        $htmlOptions['alt'] = '';
    if ($width !== null)
        $htmlOptions['width'] = $width;
    if ($height !== null)
        $htmlOptions['height'] = $height;
    return CHtml::tag('img', $htmlOptions);
}

/**
 * This is the shortcut to Yii::t().
 * Note that the category parameter is removed from the function.
 * It defaults to 'application'. If a different category needs to be specified,
 * it should be put as a prefix in the message, separated by '|'.
 * For example, t('backend|this is a test').
 */
function t($message, $params = array(), $source = null, $language = null) {
    if (($pos = strpos($message, '|')) !== false) {
        $category = substr($message, 0, $pos);
        $message = substr($message, $pos + 1);
    }
    else
        $category = 'application';
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route, $params = array(), $ampersand = '&') {
    return Yii::app()->getUrlManager()->createUrl($route, $params, $ampersand);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url = '') {
    static $baseUrl;
    if ($baseUrl === null)
        $baseUrl = Yii::app()->request->baseUrl;
    return $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name) {
    return Yii::app()->params[$name];
}

/**
 * This is the shortcut to Yii::app()->user.
 * @return WebUser
 */
function user() {
    return Yii::app()->user;
}

/**
 * This is the shortcut to Yii::app()
 * @return CWebApplication
 */
function app() {
    return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 * @return CClientScript
 */
function cs() {
    return Yii::app()->clientScript;
}

/**
 * This is the shortcut to Yii::app()->db
 * @return CDbConnection
 */
function db() {
    return Yii::app()->db;
}

/**
 * This is the shortcut to Yii::app()->getRequest
 * @return CHttpRequest object
 */
function r() {
    return Yii::app()->getRequest();
}

/**
 * This is the shortcut to Yii::app()->user->checkAccess().
 */
function allow($operation, $params = array(), $allowCaching = true) {
    return Yii::app()->user->checkAccess($operation, $params, $allowCaching);
}

/**
 * Ensures the current user is allowed to perform the specified operation.
 * An exception will be thrown if not.
 * This is similar to {@link access} except that it does not return value.
 */
function ensureAllow($operation, $params = array(), $allowCaching = true) {
    if (!Yii::app()->user->checkAccess($operation, $params, $allowCaching))
        throw new CHttpException(403, Yii::t('error', 'You are not allowed to perform this operation.'));
    return true;
}

/**
 * Shortcut to Yii::app()->format (utilities for formatting structured text)
 */
function format() {
    return Yii::app()->format;
}

/**
 * Shortcut for json_encode
 * NOTE: json_encode exists in PHP > 5.2, so it's safe to use it directly without checking
 * @param array $json the PHP array to be encoded into json array
 * @param int $opts Bitmask consisting of JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_FORCE_OBJECT.
 */
function je($json, $opts = null) {
//return function_exists('json_encode')? json_encode($json) : CJSON::encode($json);
    return json_encode($json, $opts);
}

/**
 * Shortcut for json_decode
 * NOTE: json_encode exists in PHP > 5.2, so it's safe to use it directly without checking
 * @param string $json the PHP array to be decoded into json array
 * @param bool $assoc when true, returned objects will be converted into associative arrays.
 * @param int $depth User specified recursion depth.
 * @param int $opts Bitmask of JSON decode options.
 * 	Currently only JSON_BIGINT_AS_STRING is supported
 * 	(default is to cast large integers as floats)
 */
function jd($json, $assoc = null, $depth = 512, $opts = 0) {
    return json_decode($json, $assoc, $depth);
}

/**
 * Adds trailing dots to a string if exceeds the length specified
 * @param string $txt the text to cut
 * @param integer $length the length
 * @param string $encoding the encoding type if multibyte, null otherwise
 * @return string
 */
function trail($txt, $length, $encoding = 'utf-8') {
    if (strlen($txt) > $length) {
        if (null != $encoding) {
            $txt = mb_substr($txt, 0, $length - 3, $encoding);
            $pos = mb_strrpos($txt, ' ', null, $encoding);
            $txt = mb_substr($txt, 0, $pos, $encoding) . '...';
        } else {
            $txt = substr($txt, 0, $length - 3);
            $pos = strrpos($txt, ' ');
            $txt = substr($txt, 0, $pos) . '...';
        }
    }
    return $txt;
}

/**
 * Email obfuscator script 2.1 by Tim Williams, University of Arizona.
 * Random encryption key feature by Andrew Moulden, Site Engineering Ltd
 * PHP version coded by Ross Killen, Celtic Productions Ltd
 * This code is freeware provided these six comment lines remain intact
 * A wizard to generate this code is at http://www.jottings.com/obfuscator/
 * The PHP code may be obtained from http://www.celticproductions.net/\n\n";
 *
 * @param string $address the email address to obfuscate
 * @return string
 */
function obfuscateEmail($address) {
    $address = strtolower($address);
    $coded = "";
    $unmixedkey = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.@";
    $inprogresskey = $unmixedkey;
    $mixedkey = "";
    $unshuffled = strlen($unmixedkey);
    for ($i = 0; $i <= strlen($unmixedkey); $i++) {
        $ranpos = rand(0, $unshuffled - 1);
        $nextchar = substr($inprogresskey, $ranpos, 1);
        $mixedkey .= $nextchar;
        $before = substr($inprogresskey, 0, $ranpos);
        $after = substr($inprogresskey, $ranpos + 1, $unshuffled - ($ranpos + 1));
        $inprogresskey = $before . '' . $after;
        $unshuffled -= 1;
    }
    $cipher = $mixedkey;

    $shift = strlen($address);

    $txt = "<script type=\"text/javascript\" language=\"javascript\">\n" .
            "<!-" . "-\n";

    for ($j = 0; $j < strlen($address); $j++) {
        if (strpos($cipher, $address{$j}) == -1) {
            $chr = $address{$j};
            $coded .= $chr;
        } else {
            $chr = (strpos($cipher, $address{$j}) + $shift) % strlen($cipher);
            $coded .= $cipher{$chr};
        }
    }


    $txt .= "\ncoded = \"" . $coded . "\"\n" .
            "  key = \"" . $cipher . "\"\n" .
            "  shift=coded.length\n" .
            "  link=\"\"\n" .
            "  for (i=0; i<coded.length; i++) {\n" .
            "    if (key.indexOf(coded.charAt(i))==-1) {\n" .
            "      ltr = coded.charAt(i)\n" .
            "      link += (ltr)\n" .
            "    }\n" .
            "    else {     \n" .
            "      ltr = (key.indexOf(coded.charAt(i))-
shift+key.length) % key.length\n" .
            "      link += (key.charAt(ltr))\n" .
            "    }\n" .
            "  }\n" .
            "document.write(\"<a href='mailto:\"+link+\"'>\"+link+\"</a>\")\n" .
            "\n" .
            "//-" . "->\n" .
            "<" . "/script><noscript>N/A" .
            "<" . "/noscript>";
    return $txt;
}

/**
 * Hàm trả về thứ ngày của một DateTime truyền vào
 * @param DateTime @date
 * @param bool $isnumber quy định trả về là 'thứ 2' hay là 'thứ hai' nếu $isnumber = false thì trả về chữ.
 * @return string;
 */
function GetDayOfWeek($date, $isnumber) {
    $dayofweek = date_format($date, 'w');
    switch ($dayofweek) {
        case 0:
            if ($isnumber)
                return 'Chủ nhật';
            else
                return 'Chủ nhật';
            break;
        case 1:
            if ($isnumber)
                return 'Thứ 2';
            else
                return 'Thứ hai';
            break;
        case 2:
            if ($isnumber)
                return 'Thứ 3';
            else
                return 'Thứ ba';
            break;
        case 3:
            if ($isnumber)
                return 'Thứ 4';
            else
                return 'Thứ tư';
            break;
        case 4:
            if ($isnumber)
                return 'Thứ 5';
            else
                return 'Thứ năm';
            break;
        case 5:
            if ($isnumber)
                return 'Thứ 6';
            else
                return 'Thứ sáu';
            break;

        default:
            if ($isnumber)
                return 'Thứ 7';
            else
                return 'Thứ bảy';
            break;
    }
}

/**
 * Hàm trả về khoảng cách thời gian truyền vào so với hiện tại(x phút trước, x giờ trước, thứ 2,xx/xx/xxxx hh:mm:ss...)
 * @param String $db_time
 * @return string;
 */
function ToDiffDate($db_time, $iscomment = true, $isshare = false) {
    $timezone = +7;
    $date = gmdate("Y-m-d H:i:s", time() + 3600 * ($timezone + date("0")));
    $datetime1 = date_create($date);
    $datetime2 = date_create($db_time);
    $interval = date_diff($datetime1, $datetime2);
    $day = $interval->format('%a');
    $hours = $interval->format('%H');
    $min = $interval->format('%i');
    if ($day == 0) {
        if ($hours == 0) {
            if ($min == 0) {
                if ($iscomment == false) {
                    if ($isshare == true)
                        return 'Vừa chia sẻ';
                    else
                        return 'Vừa post';
                }
                return "Vừa bình luận";
            }
            return "$min phút trước";
        }
        else
            return "$hours giờ trước";
    }
    elseif ($day == 1)
        return "1 ngày trước";
    else {
        $date_str = new DateTime($db_time);
        $day_str = GetDayOfWeek($date_str, true);
        $str_time = $day_str . ', ' . date('d/m/Y H:i:s', strtotime($db_time));
        return $str_time; // date('D/M/Y H:i:s',strtotime($value['time']));
    }
}

function sort_array_by_field($original, $field, $descending = false) {
    $sortArr = array();

    foreach ($original as $key => $value) {
        $sortArr[$key] = $value[$field];
    }

    if ($descending) {
        arsort($sortArr);
    } else {
        asort($sortArr);
    }

    $resultArr = array();
    foreach ($sortArr as $key => $value) {
        $resultArr[$key] = $original[$key];
    }

    return $resultArr;
}

function checkValues($value) {
    $value = trim($value);
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    $value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

function extract_tags($html, $tag, $selfclosing = null, $return_the_entire_tag = false, $charset = 'ISO-8859-1') {

    if (is_array($tag)) {
        $tag = implode('|', $tag);
    }

//If the user didn't specify if $tag is a self-closing tag we try to auto-detect it
//by checking against a list of known self-closing tags.
    $selfclosing_tags = array('area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta', 'col', 'param');
    if (is_null($selfclosing)) {
        $selfclosing = in_array($tag, $selfclosing_tags);
    }

//The regexp is different for normal and self-closing tags because I can't figure out
//how to make a sufficiently robust unified one.
    if ($selfclosing) {
        $tag_pattern = '@<(?P<tag>' . $tag . ')			# <tag
			(?P<attributes>\s[^>]+)?		# attributes, if any
			\s*/?>					# /> or just >, being lenient here
			@xsi';
    } else {
        $tag_pattern = '@<(?P<tag>' . $tag . ')			# <tag
			(?P<attributes>\s[^>]+)?		# attributes, if any
			\s*>					# >
			(?P<contents>.*?)			# tag contents
			</(?P=tag)>				# the closing </tag>
			@xsi';
    }

    $attribute_pattern = '@
		(?P<name>\w+)							# attribute name
		\s*=\s*
		(
			(?P<quote>[\"\'])(?P<value_quoted>.*?)(?P=quote)	# a quoted value
			|							# or
			(?P<value_unquoted>[^\s"\']+?)(?:\s+|$)			# an unquoted value (terminated by whitespace or EOF)
		)
		@xsi';

//Find all tags
    if (!preg_match_all($tag_pattern, $html, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
//Return an empty array if we didn't find anything
        return array();
    }

    $tags = array();
    foreach ($matches as $match) {

//Parse tag attributes, if any
        $attributes = array();
        if (!empty($match['attributes'][0])) {

            if (preg_match_all($attribute_pattern, $match['attributes'][0], $attribute_data, PREG_SET_ORDER)) {
//Turn the attribute data into a name->value array
                foreach ($attribute_data as $attr) {
                    if (!empty($attr['value_quoted'])) {
                        $value = $attr['value_quoted'];
                    } else if (!empty($attr['value_unquoted'])) {
                        $value = $attr['value_unquoted'];
                    } else {
                        $value = '';
                    }

//Passing the value through html_entity_decode is handy when you want
//to extract link URLs or something like that. You might want to remove
//or modify this call if it doesn't fit your situation.
                    $value = html_entity_decode($value, ENT_QUOTES, $charset);

                    $attributes[$attr['name']] = $value;
                }
            }
        }

        $tag = array(
            'tag_name' => $match['tag'][0],
            'offset' => $match[0][1],
            'contents' => !empty($match['contents']) ? $match['contents'][0] : '', //empty for self-closing tags
            'attributes' => $attributes,
        );
        if ($return_the_entire_tag) {
            $tag['full_tag'] = $match[0][0];
        }

        $tags[] = $tag;
    }

    return $tags;
}

function in_array_field($needle, $needle_field, $haystack, $strict = false) {

    if ($strict) {
        foreach ($haystack as $item)
            if ($item["$needle_field"] === $needle)
                return true;
    }
    else {
        foreach ($haystack as $item)
            if ($item["$needle_field"] == $needle)
                return true;
    }
    return false;
}

function filter_content($str) {
    $p = new CHtmlPurifier();
    $p->options = array('URI.AllowedSchemes' => array(
            'http' => true,
            'https' => true,
        ),
            //'HTML.AllowedAttributes' => 'style, id, class, target, src, href',
    );

    return $p->purify($str);
}

function zeropad($num, $lim) {
    return (strlen($num) >= $lim) ? $num : zeropad("0" . $num, $lim);
}

function convertYeucau($transaction_type) {
    if ($transaction_type == 1)
        return 'Bán';
    else
        return 'Mua';
}

function converttrancstatus($transaction_status, $arrayCONS_BUY_PROGRESS) {
    foreach ($arrayCONS_BUY_PROGRESS as $value) {
        if ($transaction_status == $value['value'])
            return $value['display_value'];
    }
}

/**
 * kiem tra ton tai thu muc va tao khi chua ton tai
 * Luan.diep
 * @param mixed $directory
 */
function checkPath($directory) {
    $parts = explode('/', rtrim($directory, '/'));
    $i = 0;

    $path = implode('/', array_slice($parts, 0, count($parts) - $i));
    while (!file_exists($path)) {
        $i++;
        $path = implode('/', array_slice($parts, 0, count($parts) - $i));
    }
    $i--;
    $path = implode('/', array_slice($parts, 0, count($parts) - $i));
    while ($i >= 0) {
        mkdir($path, 0777);
        $i--;
        $path = implode('/', array_slice($parts, 0, count($parts) - $i));
        //            $t = array_values($parts);
        //            array_splice($t, count($parts)-$i, $i);
        //            $path = implode('/', $t);
    }
}

/**
 * kiem tra ton tai cua remote file
 * luan.diep
 * @param mixed $url
 * @return mixed
 */
function remote_file_exists($url) {
    return (bool) preg_match('~HTTP/1\.\d\s+200\s+OK~', @current(get_headers($url)));
}
/**
* chuyen dinh dang chuoi so sang kieu so
* luan.diep
* @param mixed $s_money
* @param mixed $decimals
* @param mixed $dec_point
* @param mixed $thousands_sep
*/
function strtomoney($s_money, $decimals = 0, $dec_point = '.', $thousands_sep = ',')
{
    if($decimals != 0)
    {
        list($int, $float) = explode($dec_point, $s_money);
        $s_money = $int;
    }
    
    $arr_int = explode($thousands_sep, $s_money);
    $result = implode('',$arr_int);
    return isset($float) ? $result . ',' . $float : $result;
}

function word_limit($chuoi, $gioihan) {
    $chuoi = strip_tags($chuoi);
    $chuoi = preg_replace('/\s{2,}/',' ',$chuoi);
    if (mb_strlen($chuoi,'UTF-8') <= $gioihan) {
        return $chuoi;
    } else {
        /*
          so sánh vị trí cắt
          với kí tự khoảng trắng đầu tiên trong chuỗi ban đầu tính từ vị trí cắt
          nếu vị trí khoảng trắng lớn hơn
          thì cắt chuỗi tại vị trí khoảng trắng đó
         */         
        if (mb_strpos ($chuoi, " ", $gioihan,'UTF-8') > $gioihan) {
            $new_gioihan = mb_strpos($chuoi, " ", $gioihan,'UTF-8');
            $new_chuoi = mb_substr($chuoi, 0, $new_gioihan,'UTF-8') . "...";
            return $new_chuoi;
        }        
        // trường hợp còn lại không ảnh hưởng tới kết quả
        $new_chuoi = mb_substr($chuoi, 0, $gioihan,'UTF-8') . "...";           
        return $new_chuoi;
    }
}

function vn_str_filter($str) {
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}


function convert_title_url($str) {
    $str = vn_str_filter($str);
    $str =  preg_replace("/[^a-zA-Z0-9_\s-]/", "", $str);
    $str = str_replace(' ','-',$str);
    return $str;
}