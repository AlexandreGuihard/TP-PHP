<?php
declare(strict_types=1);

namespace View;

final class Template{
    private String $path;
    private String $layout;
    private String $content;

    public function __construct(String $path){
        $this->$path=$path;
    }

    public function getPath():String{
        return $this->path;
    }

    public function getLayout():String{
        return $this->layout;
    }

    public function getContent():String{
        return $this->content;
    }

    public function setLayout(String $layout):self{
        $this->$layout=$layout;
        return $this;
    }

    public function setContent(String $content):self{
        $this->$content=$content;
        return $this;
    }

    public function compile():String{
        //$content=$this->getContent();
        ob_start();
        $content=$this->getContent();
        require sprintf('%s/%s.php'.$this->getPath().$this->getLayout());
        return ob_get_clean();
    }

    public function ping():String{
        return "feur";
    }
}
?>