<?php
/**
 * Custom session class to generate and check one time Token
 * Author: Azraf
 * Author email: c.azraf@gmail.com
 */

class MWSEQ_Session
{
    public static function exists($name)
	{
	  return (isset($_SESSION[$name])) ? true : false;
    }
    
    public static function put($name, $value)
	{
	  return $_SESSION[$name] = $value;
	}
	
	public static function get($name)
	{
	  return $_SESSION[$name];
    }

    public static function delete($name)
	{
	  if (self::exists($name)) {
		 unset($_SESSION[$name]);
	  }
	}
    
    public static function token_generate()
	{
        $_SESSION['mwseq_csrf_key'] = sha1(uniqid());
        $_SESSION['mwseq_csrf_val'] = sha1(uniqid());
        return ['key' => self::get('mwseq_csrf_key'), 'val' => self::get('mwseq_csrf_val')];
	}
	
	public static function token_check($post)
	{
      if (self::exists('mwseq_csrf_key') 
        && isset($post[self::get('mwseq_csrf_key')]) 
        && ($post[self::get('mwseq_csrf_key')] === self::get('mwseq_csrf_val'))
        ) {
            $key = self::get('mwseq_csrf_key');
            self::delete('mwseq_csrf_key');
            self::delete('mwseq_csrf_val');
            return $key;  
	  }	
	  return false;
	}
}

if(!function_exists('mws_start_session')){
    function mws_start_session()
    {
        if(!session_id()) {
            session_start();
        }
    }
}

?>