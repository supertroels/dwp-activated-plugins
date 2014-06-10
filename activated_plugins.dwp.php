<?php
/*
*********************************
deployWP module template
*********************************
*/

class deploy_activated_plugins extends deployWP_module {

	/**
	 *
	 *
	 * @return void
	 **/
	function setup(){
		$this->collect_file = $this->env_dir.'/activated_plugins.json';
		$this->deploy_file 	= $this->deploy_from_dir.'/activated_plugins.json';
	}


	/**
	 * 
	 * 
	 * @return void
	 **/
	function collect(){
		/* Collect code goes here */
		$ac = get_option('active_plugins');
		$file = $this->collect_file;
		$file = fopen($file, 'w+');
		fwrite($file, json_encode($ac));
		fclose($file);
	}

	/**
	 * 
	 *
	 * @return void
	 **/
	function after_collect(){
		/* After collect code goes here */
	}

	/**
	 *
	 *
	 * @return void
	 **/
	function deploy(){
		/* Collect code goes here */
		if(file_exists($this->deploy_file)){
			if($ac = json_decode(file_get_contents($this->deploy_file))){

				$current_ac = get_option('active_plugins');
				update_option('active_plugins', array_merge($current_ac, $ac));

			}

		}
	}

	/**
	 *
	 *
	 * @return void
	 **/
	function after_deploy(){
		/* After deploy code goes here */

	}

}
?>