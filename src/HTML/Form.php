<?php


namespace doganoo\PHPUtil\HTML;


use doganoo\PHPAlgorithms\Datastructure\StackQueue\Queue;
use doganoo\PHPUtil\HTTP\Session;
use doganoo\PHPUtil\Util\HTMLUtil;

class Form implements IHTML {
    private $action;
    private $class;
    private $elements = null;
    private $html;
    private $method = "POST";
    private $file = false;
    private $session = null;
    private $csrfCheck = true;

    public function __construct() {
        $this->session = new Session();
        $this->elements = new Queue();
    }

    public function setCsrfCheck(bool $csrfCheck) {
        $this->csrfCheck = $csrfCheck;
    }

    public function setAction(string $action) {
        $this->action = $action;
    }

    public function setFile(bool $file) {
        $this->file = $file;
    }

    public function toString(): string {
        $this->buildHtml();
        return $this->html;
    }

    public function buildHtml() {
        $html = "<form ";
        $file = $this->file;
        $action = $this->action;
        $method = $this->method;
        $class = $this->class;

        if ($file) {
            $field = HTMLUtil::getField("enctype", "multipart/form-data");
            $html = $html . $field;
        }
        if ($action != "") {
            $field = HTMLUtil::getField("action", $action);
            $html = $html . $field;
        }
        if ($method != "") {
            $field = HTMLUtil::getField("method", $method);
            $html = $html . $field;
        }
        if ($class != "") {
            $field = HTMLUtil::getField("class", $class);
            $html = $html . $field;
        }
        $html = $html . ">";

        for ($i = 0; $i < $this->elements->queueSize(); $i++) {
            /** @var IHTML $element */
            $element = $this->elements->dequeue();
            $html .= $element->toString();
        }

        if ($this->hasCsrfCheck()) {
            $csrfToken = $this->session->read("csrf_token");
            $input = new Input();
            $input->setType("hidden");
            $input->setName("csrf_token");
            $input->setValue($csrfToken);
            $html .= $input->toString();
        }
        $html = $html . "</form>";
        $this->html = $html;
    }

    public function hasCsrfCheck(): bool {
        return $this->csrfCheck;
    }

    public function addElement(IHTML $element) {
        $this->elements->enqueue($element);
    }

    public function setClass($class) {
        $this->class = $class;
    }
}