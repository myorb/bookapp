<?php

namespace app\models;

use Yii;
use \app\models\base\Author as BaseAuthor;

/**
 * This is the model class for table "author".
 */
class Author extends BaseAuthor
{
	public function getFullName()
    {
        if ($this->firstname || $this->lastname) {
            return implode(' ', [$this->firstname, $this->lastname]);
        }
        return null;
    }
}
