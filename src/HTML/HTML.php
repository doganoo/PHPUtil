<?php


namespace doganoo\PHPUtil\HTML;


use doganoo\PHPAlgorithms\Datastructure\StackQueue\Queue;
use doganoo\PHPUtil\FileSystem\FileHandler;
use doganoo\PHPUtil\Log\FileLogger;
use doganoo\PHPUtil\Util\HTMLUtil;

class HTML {
    private $queue = null;
    private $title = "";
    private $html = "";
    private $scriptTags = [];
    private $cssArray = array();
    private $backgroundUrl = "";
    private $language = "en";
    private $charset = "utf - 8";

    public function __construct() {
        $this->queue = new Queue();
    }

    /**
     * @return Queue|null
     */
    public function getQueue(): ?Queue {
        return $this->queue;
    }

    /**
     * @return string
     */
    public function getHtml(): string {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function setHtml(string $html): void {
        $this->html = $html;
    }

    /**
     * @return array
     */
    public function getScriptTags(): array {
        return $this->scriptTags;
    }

    /**
     * @return array
     */
    public function getCssArray(): array {
        return $this->cssArray;
    }

    public function hasElements() {
        return $this->queue->isEmpty() !== false;
    }

    public function addElement(IHTML $element) {
        $this->queue->enqueue($element);
    }

    public function buildHtml() {
        $javaScriptTags = $this->buildScriptTags();
        $cssTags = $this->buildCssTags();
        $bodyContent = $this->buildBodyContent();
        $bgr = "";
        if ($this->backgroundUrl != "") {
            $background = HTMLUtil::CSSBackground($this->backgroundUrl);
            $bgr = "<style> body { $background } </style>";
        }
        $html = "<!DOCTYPE HTML>
                    <html lang='{$this->getLanguage()}'>
                        <head>
                        <meta charset='{$this->getCharset()}' content='width = device - width, initial - scale = 1.0' />
                        $javaScriptTags $cssTags $bgr
                        <title>{$this->getTitle()}</title>
                        </head>
                        <body>";
        for ($i = 0; $i < $this->queue->queueSize(); $i++) {
            /** @var IHTML $iHtml */
            $iHtml = $this->queue->dequeue();
            $html .= $iHtml->toString();
        }
        $html .= "</body>
                     </html>";
        $this->setHtml($html);
    }

    private function buildScriptTags(): string {
        $string = "";
        foreach ($this->scriptTags as $path => $type) {
            $fileHandler = new FileHandler($path);
            if (!$fileHandler->isFile()) {
                FileLogger::warn("$path is no js file path . Skipping");
                continue;
            }
            $scriptTag = HTMLUtil::buildScriptTag($type, $path);
            $string = $string . $scriptTag;
        }
        return $string;
    }

    private function buildCssTags(): string {
        $string = "";
        foreach ($this->cssArray as $path) {
            $fileHandler = new FileHandler($path);
            if (!$fileHandler->isFile()) {
                FileLogger::warn("$path is no css file path . Skipping");
                continue;
            }
            $cssTag = HTMLUtil::buildCssTag($path);
            $string = $string . $cssTag;
        }
        return $string;
    }

    /**
     * @return string
     */
    public
    function getLanguage(): string {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public
    function setLanguage(string $language): void {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getCharset(): string {
        return $this->charset;
    }

    /**
     * @param string $charset
     */
    public function setCharset(string $charset): void {
        $this->charset = $charset;
    }

    protected function getTitle(): string {
        return $this->title;
    }

    protected function setTitle(string $title) {
        $this->title = $title;
    }

    public function addCssPath(string $path) {
        $this->cssArray [] = $path;
    }

    public function addBodyContent(IHTML $content) {
        $this->body [] = $content;
    }

    protected function addScriptTag(string $path, string $type) {
        $this->scriptTags [$path] = $type;
    }

    protected function setBackgroundUrl(string $path) {
        $this->backgroundUrl = $path;
    }
}

