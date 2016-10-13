<?php


class Authority
{
    public const POST_PUBLIC = 0;
    public const POST_UNLISTED = 1;
    public const BLOG_MODERATE = 2;
    public const POST_PRIVATE_VIEW = 3;


    public const BLOG_CO_WRITER = 6;
    public const BLOG_OWNER = 7;
    public static function isValidAuthority($authorityLevel){
        return in_array($authorityLevel, [0,1,3,6,7]);
    }

}