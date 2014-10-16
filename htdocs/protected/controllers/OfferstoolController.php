<?php
class OfferstoolController extends Controller
{ 
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	} 
	public function accessRules()  
	{     
		return array(     
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array( 'admin', 'autocomplete'), 
				'users'=>array('@'),  
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}  
   
	
 
	public function actionAdmin()
	{
		//$this->layout = '//layouts/FrontendLayoutPavel'; 
		
		
		$this->render('admin');
	} 
}