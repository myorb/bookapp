<?php

namespace app\models\base;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * This is the base-model class for table "book".
 *
 * @property integer $id
 * @property string $name
 * @property string $preview
 * @property integer $author_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Book extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'created_at',
              'updatedAtAttribute' => 'updated_at',
              'value' => new Expression('NOW()'),
          ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at', ], 'required'],
            [['author_id', 'status'], 'integer'],
            [['created_at', 'updated_at','preview'], 'safe'],
            [['imageFile'], 'file'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'preview' => 'Preview',
            'author_id' => 'Author ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
