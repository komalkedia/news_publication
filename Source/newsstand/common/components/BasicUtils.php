<?php
namespace common\components;
use Yii;
use yii\base\Component;
use yii\helpers\Html;
class BasicUtils  extends Component 
{
	public function getCurrentDT(){
		$curdate=date('Y-m-d H:i:s');
		return $curdate;
	}	
}
?>