<?php

namespace app\models;

use Yii;
use \app\models\base\Book as BaseBook;
use app\models\Author;

/**
 * This is the model class for table "book".
 */
class Book extends BaseBook
{
	public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}
