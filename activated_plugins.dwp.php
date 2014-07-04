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

		add_filter( 'plugin_row_meta', array($this, 'add_deploy_notice'), 999, 4);

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
			if($ac = json_decode(file_get_contents($this->deploy_file), JSON_ARRAY)){
				
				if(!$current_ac = get_option('active_plugins') or !is_array($current_ac))
					$current_ac = array();

				$insert_ac 		= array_merge($current_ac, $ac);
				$avail_plugins 	= array_keys(get_plugins());
				foreach($insert_ac as $key => $plugin){
					if(!in_array($plugin, $avail_plugins)){
						unset($incert_ac[$key]);
					}
				}

				update_option('active_plugins', array_unique($insert_ac));

			}

		}
	}

	function add_deploy_notice($plugin_meta, $plugin_file, $plugin_data, $status){

		if(file_exists($this->deploy_file) and in_array($this->env, $this->deploy_in)){
			if($ac = json_decode(file_get_contents($this->deploy_file), JSON_ARRAY)){
				if(in_array($plugin_file, $ac)){
					$plugin_meta[] = 'Activated by deployWP';
				}
			}
		}

		return $plugin_meta;

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
