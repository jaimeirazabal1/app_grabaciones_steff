<?php 
class Role extends ActiveRecord{
	public function getRoleById($id){
		return $this->find($id);
	}	
}

 ?>