<?php
	require_once JPATH_ROOT."/libraries/mylib/Facebook/autoload.php";
	require_once JPATH_ROOT."/libraries/mylib/Google/vendor/autoload.php";
	require_once JPATH_ROOT."/libraries/mylib/Twitter/vendor/autoload.php";
	use Abraham\TwitterOAuth\TwitterOAuth;
	class Social{
		public static function getSocailParams(){
			return JComponentHelper::getParams('com_socialuser');
		}
		//Facebook登入按鈕
		public static function loadFacebookLoginButton(){
			$params = self::getSocailParams();
			$fb = new Facebook\Facebook([
			  'app_id' => $params->get('facebook_app_id'),
			  'app_secret' => $params->get('facebook_secret'),
			  'default_graph_version' => 'v2.2',
			]);
			$helper = $fb->getRedirectLoginHelper();
			$loginUrl = $helper->getReRequestUrl(JURI::root().'?option=com_socialuser&task=facebook.login', array("public_profile","email"));
			ob_start();
		?>
		<a href="<?php echo $loginUrl; ?>" class="btn btn-default btn-sm"><i class="fa fa-facebook-official fa-fw" style="color:blue;"></i>&nbsp;<?php echo JText::sprintf('ETC_USE_SOCIAL_LOGIN','Facebook'); ?></a>
		<?php
			ob_end_flush();
		}
		//Facebook連結按鈕
		public static function loadFacebookLinkButton(){
			$params = self::getSocailParams();
			$fb = new Facebook\Facebook([
			  'app_id' => $params->get('facebook_app_id'),
			  'app_secret' => $params->get('facebook_secret'),
			  'default_graph_version' => 'v2.2',
			]);
			$helper = $fb->getRedirectLoginHelper();
			$linkUrl = $helper->getReRequestUrl(JURI::root().'?option=com_socialuser&task=facebook.link', array("public_profile","email"));
			ob_start();
		?>
		<a href="<?php echo $linkUrl; ?>" class="btn btn-default btn-sm"><i class="fa fa-facebook-official fa-fw" style="color:blue;"></i>&nbsp;<?php echo JText::sprintf('ETC_USE_SOCIAL_LINK','Facebook'); ?></a>
		<?php
			ob_end_flush();
		}
		//Facebook取消連結按鈕
		public static function loadFacebookUnlinkButton($register = 0){
			$unlinkUrl = JURI::root() . "?option=com_socialuser&task=facebook.unlink";
			ob_start();
		?>
		<a href="<?php echo $unlinkUrl; ?>" class="btn btn-default btn-sm active <?php if($register) echo "disabled"; ?>"><i class="fa fa-facebook-official fa-fw" style="color:blue;"></i>&nbsp;<?php echo JText::sprintf('ETC_CANCEL_SOCIAL_LINK','Facebook'); ?></a>
		<?php
			ob_end_flush();
		}
		//Google登入按鈕
		public static function loadGoogleLoginButton(){
			$params = self::getSocailParams();
			$client = new Google_Client();
			$client->setAccessType('online'); // default: offline
			$client->setClientId($params->get('google_client_id'));
			$client->setClientSecret($params->get('google_client_password'));
			$client->setRedirectUri(JURI::root().'?option=com_socialuser&task=google.login');
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");
			$loginUrl = $client->createAuthUrl();
			ob_start();
		?>
		<a href="<?php echo $loginUrl; ?>" class="btn btn-default btn-sm"><i class="fa fa-google fa-fw" style="color:red;"></i>&nbsp;<?php echo JText::sprintf('ETC_USE_SOCIAL_LOGIN','Google'); ?></a>
		<?php
			ob_end_flush();
		}
		//Google連結按鈕
		public static function loadGoogleLinkButton(){
			$params = self::getSocailParams();
			$client = new Google_Client();
			$client->setAccessType('online'); // default: offline
			$client->setClientId($params->get('google_client_id'));
			$client->setClientSecret($params->get('google_client_password'));
			$client->setRedirectUri(JURI::root().'?option=com_socialuser&task=google.link');
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");
			$linkUrl = $client->createAuthUrl();
			ob_start();
		?>
		<a href="<?php echo $linkUrl; ?>" class="btn btn-default btn-sm"><i class="fa fa-google fa-fw" style="color:red;"></i>&nbsp;<?php echo JText::sprintf('ETC_USE_SOCIAL_LINK','Google'); ?></a>
		<?php
			ob_end_flush();
		}
		//Google取消連結按鈕
		public static function loadGoogleUnlinkButton($register = 0){
			$unlinkUrl = JURI::root() . "?option=com_socialuser&task=google.unlink";
			ob_start();
		?>
		<a href="<?php echo $unlinkUrl; ?>" class="btn btn-default btn-sm active <?php if($register) echo "disabled"; ?>"><i class="fa fa-google fa-fw" style="color:red;"></i>&nbsp;<?php echo JText::sprintf('ETC_CANCEL_SOCIAL_LINK','Google'); ?></a>
		<?php
			ob_end_flush();
		}
		//Twitter登入按鈕
		public static function loadTwitterLoginButton(){
			$params = self::getSocailParams();
			$connection = new TwitterOAuth($params->get('twiiter_app_key_for_login'), $params->get('twiiter_app_secret_for_login'));
			$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => 'http://127.0.0.1/etcswtest/?option=com_socialuser&task=twitter.login'));
			JFactory::getSession()->set('oauth_login_token',$request_token['oauth_token']);
			JFactory::getSession()->set('oauth_login_token_secret',$request_token['oauth_token_secret']);
			$loginUrl = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
			ob_start();
		?>
		<a href="<?php echo $loginUrl; ?>" class="btn btn-default btn-sm"><i class="fa fa-twitter fa-fw" style="color:skyblue;"></i>&nbsp;<?php echo JText::sprintf('ETC_USE_SOCIAL_LOGIN','Twitter'); ?></a>
		<?php
			ob_end_flush();
		}
		//Twitter連結按鈕
		public static function loadTwitterLinkButton(){
			$params = self::getSocailParams();
			$connection = new TwitterOAuth($params->get('twiiter_app_key_for_link'),$params->get('twiiter_app_secret_for_link'));
			$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => 'http://127.0.0.1/etcswtest/?option=com_socialuser&task=twitter.link'));
			JFactory::getSession()->set('oauth_link_token',$request_token['oauth_token']);
			JFactory::getSession()->set('oauth_link_token_secret',$request_token['oauth_token_secret']);
			$linkUrl = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
			ob_start();
		?>
		<a href="<?php echo $linkUrl; ?>" class="btn btn-default btn-sm"><i class="fa fa-twitter fa-fw" style="color:skyblue;"></i>&nbsp;<?php echo JText::sprintf('ETC_USE_SOCIAL_LINK','Twitter'); ?></a>
		<?php
			ob_end_flush();
		}
		//Twitter取消連結按鈕
		public static function loadTwitterUnlinkButton($register = 0){
			$unlinkUrl = JURI::root() . "?option=com_socialuser&task=twitter.unlink";
			ob_start();
		?>
		<a href="<?php echo $unlinkUrl; ?>" class="btn btn-default btn-sm active <?php if($register) echo "disabled"; ?>"><i class="fa fa-twitter fa-fw" style="color:skyblue;"></i>&nbsp;<?php echo JText::sprintf('ETC_CANCEL_SOCIAL_LINK','Twitter'); ?></a>
		<?php
			ob_end_flush();
		}
		public static function getUserId($email,$type){
			if(!$email || !$type) return NULL;
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('user_id')->from('#__social')->where($db->quoteName('email') . " = " . $db->quote($email))->where($db->quoteName('type') . " = " . $db->quote($type));
			$db->setQuery($query);
			return $db->loadResult();
		}
		
		public static function getSocialData($user_id,$type){
			if(!$user_id) return NULL;
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('*')->from('#__social')->where($db->quoteName('user_id') . " = " . $db->quote($user_id))->where($db->quoteName('type') . " = " . $db->quote($type));
			$db->setQuery($query);
			return $db->loadObject();
		}
		public static function isSocialRegister($user_id){
			if(!$user_id) return NULL;
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('COUNT(*)')->from('#__social')->where($db->quoteName('user_id') . " = " . $db->quote($user_id))->where($db->quoteName('register') . " = '1'");
			$db->setQuery($query);
			return $db->loadResult();
		}
	}
?>