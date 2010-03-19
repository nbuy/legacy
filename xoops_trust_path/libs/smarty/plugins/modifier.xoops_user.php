<?php
/**
 *
 * @package Legacy
 * @version $Id: modifier.xoops_user.php,v 1.3 2008/09/25 15:12:36 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://xoopscube.sourceforge.net/license/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     xoops_user
 * Purpose:  Adapter for XoopsUserObject::getVar with using $uid parameter.
 * Input:    uid : user id
 *           key : XoopsUserObject property name
 *           flag: Enum(Profile_ActionType) 
 *             If you set 0, you can get raw value.
 *             If you set 2 or nothing, you can get escaped value.
 * -------------------------------------------------------------
 */
function smarty_modifier_xoops_user($uid, $key, $flag=0)
{
	$flag = isset($flag) ? $flag : 2;
	if(in_array($key, Profile_DefinitionsHandler::getReservedNameList())){
		$handler=&xoops_gethandler('member');
		$user=&$handler->getUser(intval($uid));
		if(is_object($user) && $user->isActive()) {
			return ($flag==2) ? $user->getShow($key) : $user->get($key);
		}
	}
	else{
		$handler =& Legacy_Utils::getModuleHandler('data', 'profile');
		$user =& $handler->get($uid);
		if(is_object($user) && $user->isActive()) {
			return $user->showField($key, $flag);
		}
	}

	return null;
}

?>
