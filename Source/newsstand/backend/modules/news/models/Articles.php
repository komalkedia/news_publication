<?php

namespace backend\modules\news\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $imageurl
 * @property string $description
 * @property string $createdat
 * @property string $useremail
 */
class Articles extends \common\newslibrary\NewsActiveRecords
{
	public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'imageurl', 'description', 'useremail'], 'required'],
            [['description'], 'string'],
            [['createdat'], 'safe'],
            [['title', 'imageurl'], 'string', 'max' => 500],
            [['useremail'], 'string', 'max' => 255],
            [['imageFile'], 'file',/*  'skipOnEmpty' => true, */ 'extensions' => 'jpeg,gif,bmp,png,jpg', 'maxFiles' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'imageurl' => 'Article Image',
            'description' => 'Description',
            'createdat' => 'Created at',
            'useremail' => 'User Email',
        ];
    }

    /**
     * @inheritdoc
     * @return ArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticlesQuery(get_called_class());
    }
}
