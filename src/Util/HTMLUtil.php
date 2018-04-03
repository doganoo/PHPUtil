<?php


namespace doganoo\PHPUtil\Util;


final class HTMLUtil {
    private function __construct() {
    }

    public static function CSSBackground(string $url): string {
        return "background-image: url(\"$url\");";
    }

    public static function buildScriptTag(string $type, string $path): string {
        return "<script type='$type' src='$path' ></script >";
    }

    public static function buildCssTag(string $path): string {
        return "<link rel = 'stylesheet' href = '$path' >";
    }

    public static function getField(string $type, string $value): string {
        return " $type = '$value' ";
    }

    public static function getHyperReference(string $link, bool $newTab = false): string {
        $newTabString = $newTab ? "target='_blank'" : "";
        return "<a $newTabString href='$link'>";
    }
}