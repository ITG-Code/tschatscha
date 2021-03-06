<?php

/**
 * Class Lang standard language is English
 */
class Lang
{
    // Forms
    const FORM_CONFIRMATION_PASSWORD_SENT_NO = "No confirmation password sent";
    const FORM_PASSWORD_ORIGINAL_INVALID = "Original password didn't match the one submitted";
    const FORM_PASSWORD_SENT_NO = "You need to send your password to confirm";
    const FORM_PASSWORD_NEW_SENT_NO = "No new password sent";
    const FORM_PASSWORD_NEW_NO_MATCH = "New Password and Password confirmation didn't match";
    const FORM_ALIAS_SENT_NO = "You need to send an alias";
    const FORM_BLOGNAME_NEEED_4_CHAR = "The blogname needs to be atleast 4 characters long";
    const FORM_BLOGNAME_INVALID_CHARS = "Allowed characters are a-ö, A-Ö, 0-9, hyphen(-) and underline(_)";
    const FORM_BLOGURL_INVALID_CHARS = "Allowed characters are a-z, A-Z, 0-9, hyphen(-) and underline(_)";
    const FORM_EMAIL_SENT_NO = "No email set";
    const FORM_POST_URL_INVALID_CHARS = "Allowed characters are a-z, A-Z, 0-9 and hyphen(-)";
    const FORM_POST_DATE_INVALID = "Invalid date. Please insert a valid date";
    const FORM_POST_URL_NOT_UNIQUE = "The Title you specified is not unique for your blog";
    const FORM_TAGS_EXCEED_CHAR_LIMIT = "Your tags exceed the character limit";
    const FORM_TAG_EXCEED_CHAR_LIMIT = "One of your tags exceed the character limit(30)";

    // Forms are valid but other errors sent
    const WARNING_USERNAME_ALREADY_IN_USE = "That username is already in use";
    const WARNING_EMAIL_ALREADY_IN_USE = "That email is already in use";
    const WARNING_ALIAS_ALREADY_IN_USE = "That alias is already in use";
    const WARNING_BLOG_URLNAME_ALREADY_IN_USE = "That  is already in use";
    const WARNING_USERNAME_EXIST_NO = "That username doesn't exist";
    const WARNING_USERNAME_PASSWORD_COMBINATION_INVALID = "That Username and password combination doesn't exist";

    // Causes of redirect made without checking of form, alt: Misc
    const ACCESS_LOGGED_IN_NO = "You need to be logged in to access that page";
    const TOKEN_INVALID = "Token not valid";
    const EMAIL_VERIFIED_NO = "Your email has not been verified, please check your email";
    const FORM_BLOGNAME_RESERVED_NAME = "Url is already reserved";
    const FORM_URLNAME_NOT_UNIQUE = "The URL you entered is already in use";
    const BLOG_POST_CONNECTION_MISSING = "No connection between blog and post was found";
    const ERROR_OCCURED = "An error has occured";
}
