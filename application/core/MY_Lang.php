<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Lang extends CI_Lang
{

    var $languages = array(

        'ru' => 'russian',
        'uz' => 'uzbek',
        'en' => 'english',

        'oz' => 'ozbek',
        'ar' => 'arabic',
        'qr' => 'qr',

    );

    // special URIs (not localized)
    var $special = array(
       // 'admin',
        'thumb',
        'auth',
        'deploy',
        'fb_login',
        'tw_login',
        'verify'
    );

    var $default_uri = 'ru';

    /**************************************************/


    function __construct()
    {
        parent::__construct();

        global $CFG;
        global $URI;
        global $RTR;

        $segment = $URI->segment(1);

        if (isset($this->languages[$segment]))
        {
            $CFG->set_item('language', $this->languages[$segment]);
        } else if ($this->is_special($segment))
        {
            return;
        } else {
            $CFG->set_item('language', $this->languages[$this->default_lang()]);
        }

        define('LANG', $this->lang());
    }


    function lang()
    {
        global $CFG;
        $language = $CFG->item('language');

        $lang = array_search($language, $this->languages);
        if ($lang) {
            return $lang;
        }

        return NULL;
    }

    function is_special($uri)
    {
        $exploded = explode('/', $uri);
        if (in_array($exploded[0], $this->special)) {
            return TRUE;
        }
        if (isset($this->languages[$uri])) {
            return TRUE;
        }
        return FALSE;
    }

    function switch_uri($lang)
    {
        $CI =& get_instance();

        $uri = $CI->uri->uri_string();
        if ($uri != "") {
            $exploded = explode('/', $uri);
            if ($exploded[0] == $this->lang()) {
                $exploded[0] = $lang;
            }
            $uri = implode('/', $exploded);
        }
        return $uri;
    }

    function has_language($uri)
    {
        $first_segment = NULL;

        $exploded = explode('/', $uri);
        if (isset($exploded[0])) {
            if ($exploded[0] != '') {
                $first_segment = $exploded[0];
            } else if (isset($exploded[1]) && $exploded[1] != '') {
                $first_segment = $exploded[1];
            }
        }

        if ($first_segment != NULL) {
            return isset($this->languages[$first_segment]);
        }

        return FALSE;
    }

    function default_lang()
    {
        foreach ($this->languages as $lang => $language) {
            return $lang;
        }
    }

    function localized($uri)
    {
        if ($this->has_language($uri) || $this->is_special($uri) || preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri)) {
        } else {
            $uri = $this->lang() . '/' . $uri;
        }
        return $uri;
    }
}
