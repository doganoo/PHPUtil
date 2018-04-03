<?php


namespace doganoo\PHPUtil\HTML;


use doganoo\PHPAlgorithms\Datastructure\StackQueue\Queue;
use doganoo\PHPUtil\Util\HTMLUtil;

class Button implements IHTML {
    private $name;
    private $class;
    private $id;
    private $elements = null;
    private $html;

    public function __construct() {
        $this->elements = new Queue();
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setClass(string $class) {
        $this->class = $class;
    }

    public function setId(string $id) {
        $this->id = $id;
    }

    public function addElement(IHTML $element) {
        $this->elements->enqueue($element);
    }

    public function toString() {
        $this->buildHtml();
        return $this->html;
    }

    public function buildHtml() {
        $html = "<button ";
        $class = $this->class;
        $id = $this->id;
        if ($class != "") {
            $html .= HTMLUtil::getField("class", $class);
        }
        if ($id != "") {
            $html .= HTMLUtil::getField("id", $id);
        }
        $html = $html . " >";
        for ($i = 0; $i < $this->elements->queueSize(); $i++) {
            /** @var IHTML $element */
            $element = $this->elements->dequeue();
            if ($element instanceof IHTML) {
                $html .= $element->toString();
            }
        }
        $html = $html . "</button>";
        $this->html = $html;
    }
}
