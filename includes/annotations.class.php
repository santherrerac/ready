<?php

abstract class annotations
{
	
	public static function get_property_annotations($obj, $property_name)
	{
		$prop = new ReflectionProperty(get_class($obj), $property_name);
	    $doc = $prop->getDocComment();
	    preg_match_all('/@([a-z_0-9]+)\s(.*?)\n/i', $doc, $matches);

	    $annotations = array();

	    foreach ($matches[1] as $key => $value)
	    {	
	    	$annotations[$matches[1][$key]] = $matches[2][$key];
	    }

	    return $annotations;
	}
}

?>