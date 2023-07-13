<?php 

	class hello
	{
		var $user_name;
		function set_name($user_name)
		{
			$this->name = $user_name;
		}
		function get_name()
		{
			return $this->name;
		}
	}

?>