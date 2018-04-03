<?php


namespace doganoo\PHPUtil\HTML;


use doganoo\PHPUtil\Util\HTMLUtil;

class Cell implements IHTML {
    private $class;
    private $id;
    private $element = null;
    private $html;
    private $name;
    private $link;
    private $isHead = false;
    private $linkInNewTab = false;

    public function setLink($link, $linkInNewTab = false) {
        $this->link = $link;
        $this->linkInNewTab = $linkInNewTab;
    }

    public function setHead(bool $head) {
        $this->isHead = $head;
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

    public function toString(): string {
        $this->buildHtml();
        return $this->html;
    }

    public function buildHtml() {
        if ($this->isHead) {
            $html = "<th";
        } else {
            $html = "<td";
        }
        $class = $this->class;
        $id = $this->id;
        $name = $this->name;
        $link = $this->link;

        if ($class != "") {
            $html = $html . HTMLUtil::getField("class", $class);
        }
        if ($id != "") {
            $html = $html . HTMLUtil::getField("id", $id);
        }
        if ($name != "") {
            $html = $html . HTMLUtil::getField("name", $name);
        }
        $html = $html . ">";
        if ($link != "") {
            $reference = HTMLUtil::getHyperReference($this->link, $this->linkInNewTab);
            $html = $html . $reference;
        }
        $element = "";
        if (null !== $this->getElement()) {
            $element = $this->getElement()->toString();
        }
        $html = $html . $element;
        if ($this->isHead) {
            $html = $html . "</th>";
        } else {
            $html = $html . "</td>";
        }
        if ($link != "") {
            $html = $html . "</a>";
        }
        $this->html = $html;
    }

    public function getElement(): ?IHTML {
        return $this->element;
    }

    public function setElement(IHTML $element) {
        $this->element = $element;
    }
}