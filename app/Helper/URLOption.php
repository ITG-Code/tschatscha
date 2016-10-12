<?php


class URLOption
{
    public static $page = 1;
    public static $limit = 10;
    public static $search = '';

    public static function parse(array $urlArray)
    {
        $pageIndex = array_search('page', $urlArray);
        if ($pageIndex) {
            $page = (isset($urlArray[$pageIndex + 1])) ? $urlArray[$pageIndex + 1] : self::$page;
            $page = (is_numeric($page)) ? floor($page) : self::$page;
            self::$page = $page;
        }

        $limitIndex = array_search('limit', $urlArray);
        if ($limitIndex) {
            $limit = (isset($urlArray[$limitIndex + 1])) ? $urlArray[$limitIndex + 1] : self::$limit;
            $limit = (is_numeric($limit)) ? floor($limit) : self::$limit;
            self::$limit = $limit;
        }

        $searchIndex = array_search('search', $urlArray);
        if ($searchIndex) {
            $search = (isset($urlArray[$searchIndex + 1])) ? $urlArray[$searchIndex + 1] : self::$search;
            self::$search = $search;
        }
    }
}