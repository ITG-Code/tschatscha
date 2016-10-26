<?php


class Authority
{
    const POST_PUBLIC = 0;
    const POST_UNLISTED = 1;
    const BLOG_MODERATE = 2;
    const POST_PRIVATE_VIEW = 3;
    


    const BLOG_CO_WRITER = 6;
    const BLOG_OWNER = 7;


    public static function isValidAuthority($authorityLevel)
    {
        return in_array($authorityLevel, [0,1,3,6,7]);
    }
}
