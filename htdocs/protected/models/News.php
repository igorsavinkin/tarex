<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property integer $id
 * @property string $newsDate
 * @property string $title
 * @property string $imageUrl
 * @property string $content
 * @property string $RSSchannel
 * @property integer $isActive
 */
class News extends CActiveRecord
{
	public function tableName()
	{
		return '{{news}}';
	}

	public function rules()
	{
		
		return array(
			//array('newsDate, title, imageUrl, content', 'required'),
			array('title', 'length', 'max'=>1000),
			array('isActive', 'numerical', 'integerOnly' =>true),			
			array('content', 'length', 'max'=>65355),
			array('imageUrl, link, RSSchannel', 'length', 'max'=>255),			
			array('id, newsDate, title, imageUrl, content, link, isActive, RSSchannel', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
	public function scopes()
    {
        return array( 
            'first5'=>array(
                'order'=>'id ASC',
                'limit'=>5,
            ), 
        );
    } 
	public function attributeLabels()
	{
		return array(
			'id' 			  => Yii::t('general','ID'),
			'newsDate' => Yii::t('general','News Date'),
			'title'			  => Yii::t('general','Title'),
			'link' 			  => Yii::t('general','Link'),
			'imageUrl'   => Yii::t('general','Image Url'),
			'content' 	  => Yii::t('general','Content'),
			'RSSchannel' 	  => Yii::t('general','RSS Channel'),
			'isActive' 	  => Yii::t('general','is Active'),
		);
	}
	 
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('newsDate',$this->newsDate,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('imageUrl',$this->imageUrl,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('RSSchannel',$this->RSSchannel,true);
		$criteria->compare('isActive',$this->isActive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}