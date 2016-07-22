<?php
	class customUser{
		public static function getUserId($username = null,$email = null){
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('id')->from('#__users');
			if($username)
				$query->where($db->quoteName('username') . " = " .$db->quote($username));
			if($email)
				$query->where($db->quoteName('email') . " = " .$db->quote($email));
			$db->setQuery($query);
			return $db->loadResult();
		}
	}
?>