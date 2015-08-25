<?php
	class Oracle{
		private $products;

		private function get_json($file){
			if(is_file($file)){
				return json_decode(file_get_contents($file), true);
			}
		}

		private function set_json($array, $file){
			if(is_file($file)){
				if(!empty($array)){
					file_put_contents($file, json_encode($array));
				}
			}
			echo "{\"success\" : \"true\"}";
		}

		private function search($array, $searched){
			foreach ($array as $key => $value) {
				if($value["id"] == $searched){
					return $value;
				}
			}
		}

		private function delete($array, $searched){
			unset($array[$searched]);
			$this->set_json($array, "./data/products.json");
		}

		public function __construct(){
			$this->products = $this->get_json("./data/products.json");
		}

		public static function get_root(){
			echo "Products Managment";
		}

		public function get_product($id = null){
			if(empty($id)){
				echo json_encode($this->products);
			}
			else{
				echo json_encode($this->search($this->products["products"], $id));
			}
		}

		public function save_product($post, $id = null){
			if(!empty($id)){
				$this->delete_product($id);
			}
			array_push($this->products["products"], 
				array("id"    => $post["id"],
					  "name"  => $post["name"],
					  "value" => $post["value"]));
			$this->set_json($this->products, "./data/products.json");
		}

		public function delete_product($id){
			$this->delete($this->products["products"], $id);
		}
	}
?>