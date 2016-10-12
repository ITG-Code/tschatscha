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
    const FORM_BLOGNAME_INVALID_CHARS = "Allowed characters are a-z, A-Z, 0-9, hyphen(-) and underline(_)";
    const FORM_EMAIL_SENT_NO = "No email set";

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
}