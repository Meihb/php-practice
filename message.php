<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-5
 * Time: 14:52
 */


/************面向对象留言本**************/
class message
{//留言实体类
    public $name;//留言者姓名
    public $email;//留言者邮箱
    public $content;//留言内容

    public function __set($name, $value)
    {
        $this->name = $value;
    }

    public function __get($name)
    {
        if (!isset($this->$name)) {
            $this->$name = null;
        }
        return $this->$name;
    }
}

/*
 * 留言本模型,负责管理留言本
 * $bookPath:留言本属性
 */

class gbookModel
{
    private $bookPath;//留言本文件
    private $data;//留言数据

    public function setBookPath($bookPath)
    {
        $this->bookPath = $bookPath;
    }

    public function getBookPath()
    {
        return $this->bookPath;
    }

    public function open()
    {

    }

    public function close()
    {

    }

    public function read()
    {
        return file_get_contents($this->bookPath);
    }

    //写入留言
    public function write($data)
    {
        $data = static::safe($data);
//        $this->data = self::safe($data)->name . "&" . self::safe($data)->email . '&' . "\r\nsaid:\r\n" . self::safe($data)->content;
        $this->data = $data->name . "&" .$data->email . '&' . " said: " .$data->content."\r\n";
        return file_put_contents($this->bookPath, $this->data, FILE_APPEND);
    }

    public static function safe($data)
    {
        $reflect = new ReflectionObject($data);
        $props = $reflect->getProperties();
        $messagebox = new stdClass();
        foreach ($props as $prop) {
            $ivar = $prop->getName();
            $messagebox->$ivar = trim($prop->getValue($data));
        }
        var_dump($messagebox);
        return $messagebox;
    }

    public function delete()
    {
        file_put_contents($this->bookPath, 'it`s empty now');
    }
}


class leaveModel
{
    public function write(gbookModel $gbookModel, $data)
    {
        $book = $gbookModel->getBookPath();
        $gbookModel->write($data);
    }
}

class authorControl
{
    public function message(leaveModel $leaveModel, gbookModel $gbookModel, message $data)
    {
        //在留言板留言
        $leaveModel->write($gbookModel, $data);
    }

    public function view(gbookModel $gbookModel)
    {
        //查看留言内容
        return $gbookModel->read();
    }

    public function delete(gbookModel $gbookModel)
    {
        $gbookModel->delete();
        echo self::view($gbookModel);
    }
}

$messagebox = new message();
$messagebox->name = 'phper';
$messagebox->email = 'phper@phper.net';
$messagebox->content = 'a crazy phper love php so much';

$gb = new authorControl();//新建一个留言相关的控制器
$pen = new leaveModel();//拿出笔
$book = new gbookModel();//翻出笔记本
$book->setBookPath("../resource/book.txt");
$gb->message($pen, $book, $messagebox);
echo $gb->view($book);
$gb->delete($book);

//$bool = preg_match_all('/\b\w*\b/','dsadsa');
//var_dump($bool);