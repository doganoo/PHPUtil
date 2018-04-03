<?php


namespace doganoo\PHPUtil\HTML;


use doganoo\PHPUtil\Util\HTMLUtil;

class Input implements IHTML {
    const INPUT_TYPE_BUTTON = "Submit";
    const INPUT_TYPE_TEXT = "text";
    private $class;
    private $id;
    private $name;
    private $type;
    private $html;
    private $readonly;
    private $disabled = false;
    private $value;
    private $placeholder;
    private $checked;

    public function setClass(string $class) {
        $this->class = $class;
    }

    public function setChecked(bool $checked) {
        $this->checked = $checked;
    }

    public function setId(string $id) {
        $this->id = $id;
    }

    public function setValue(string $value) {
        $this->value = $value;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getDisabled(): bool {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled) {
        $this->disabled = $disabled;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type) {
        $this->type = $type;
    }

    public function setReadOnly(bool $readonly) {
        $this->readonly = $readonly;
    }

    public function setPlaceholder(string $placeholder) {
        $this->placeholder = $placeholder;
    }

    public function toString(): string {
        $this->buildHtml();
        return $this->html;
    }

    public function buildHtml() {
        $html = "<input ";
        $class = $this->class;
        $type = $this->type;
        $name = $this->name;
        $id = $this->id;
        $text = $this->value;
        $placeholder = $this->placeholder;

        if ($class != "") {
            $field = HTMLUtil::getField("class", $class);
            $html = $html . $field;
        }
        if ($type != "") {
            $field = HTMLUtil::getField("type", $type);
            $html = $html . $field;
        }
        if ($name != "") {
            $field = HTMLUtil::getField("name", $name);
            $html = $html . $field;
        }
        if ($id != "") {
            $field = HTMLUtil::getField("id", $id);
            $html = $html . $field;
        }
        if ($text != "") {
            $field = HTMLUtil::getField("value", $text);
            $html = $html . $field;
        }
        if ($this->checked != "") {
            $field = HTMLUtil::getField("checked", "");
            $html = $html . $field;
        }
        if ($this->readonly) {
            $html = $html . " readonly ";
        }
        if ($this->disabled) {
            $html = $html . " disabled ";
        }

        if ($placeholder) {
            $field = HTMLUtil::getField("placeholder", $placeholder);
            $html = $html . $field;
        }
        $html = $html . ">";
        $this->html = $html;
    }
}
