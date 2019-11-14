<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/11/14
 * Time: 11:34
 */

namespace app\models;

use Yii;
use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    /**
     * $model->validate()会根据此方法调用
     * @return array
     */
    public function rules()
    {
        echo "here its validating！";
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
}