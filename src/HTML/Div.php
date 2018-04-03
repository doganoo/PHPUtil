<?php


namespace doganoo\PHPUtil\HTML;


use doganoo\PHPAlgorithms\Datastructure\StackQueue\Queue;
use doganoo\PHPUtil\Util\HTMLUtil;

class Div implements IHTML {
    private $name;
    private $class;
    private $id;
    private $queue = null;
    private $html;

    public function __construct() {
        $this->queue = new Queue();
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
        $this->queue->enqueue($element);
    }

    public function toString(): string {
        $this->buildHtml();
        return $this->html;
    }

    public function buildHtml() {
        $html = "<div ";
        $class = $this->class;
        $id = $this->id;
        if ($class != "") {
            $field = HTMLUtil::getField("class", $class);
            $html = $html . $field;
        }
        if ($id != "") {
            $field = HTMLUtil::getField("id", $id);
            $html = $html . $field;
        }
        $html = $html . ">";
        for ($i = 0; $i < $this->queue->queueSize(); $i++) {
            /** @var IHTML $element */
            $element = $this->queue->dequeue();
            $html .= $element->toString();
        }
        $html = $html . "</div>";
        $this->html = $html;
    }
}
