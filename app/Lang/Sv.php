<?php


class Sv extends Lang
{
  const FORM_CONFIRMATION_PASSWORD_SENT_NO = "Inget bekräftelse lösenord skickat";
  const FORM_PASSWORD_ORIGINAL_INVALID = "Ursprungliga lösenordet matchar inte det som angetts";
  const FORM_PASSWORD_SENT_NO = "Du måste fylla i lösenordet för att kunna godkänna";
  const FORM_PASSWORD_NEW_SENT_NO = "Inget nytt lösenord skickat";
  const FORM_PASSWORD_NEW_NO_MATCH = "Det nya lösenordet matchar inte med ded lösenordet";
  const FORM_ALIAS_SENT_NO = "Du måste skicka in ett alias";
  const FORM_BLOGNAME_NEEED_4_CHAR = "Bloggnamnet måste vara minst 4 karaktärer långt";
  const FORM_BLOGNAME_INVALID_CHARS = "De tillåtna karaktärerna är a-z, A-Z, 0-9, bindestreck(-) och udnerstreck(_)";
  const FORM_BLOGNAME_RESERVED_NAME = "Den angivna URL:en är reserverad.";
  const FORM_URLNAME_NOT_UNIQUE = "URL:en du angav används redan";
  const FORM_EMAIL_SENT_NO = "Ingen e-postadress satt";
  const FORM_POST_URL_INVALID_CHARS = "De tillåtna karaktärerna är a-z, A-Z, 0-9 och bindestreck(-)";
  const FORM_POST_DATE_INVALID = "Ogitligt datum. Var god ange ett giltigt datum";
  const FORM_POST_URL_NOT_UNIQUE = "Titeln du specificerade är inte unik för din blog";
  const FORM_TAGS_EXCEED_CHAR_LIMIT = "Dina taggar överskrider tecken gränsen";
  const FORM_TAG_EXCEED_CHAR_LIMIT = "En av dina taggar överskrider gränsen(30 tecken)";

  // Forms are valid but other errors sent
  const WARNING_USERNAME_ALREADY_IN_USE = "Det användarnamnet är upptaget";
  const WARNING_EMAIL_ALREADY_IN_USE = "E-postadressen är upptagen";
  const WARNING_ALIAS_ALREADY_IN_USE = "Det aliaset används redan";
  const WARNING_BLOG_URLNAME_ALREADY_IN_USE = "URL:en används redan";
  const WARNING_USERNAME_EXIST_NO = "Det användarnamnet existerar inte";
  const WARNING_USERNAME_PASSWORD_COMBINATION_INVALID = "Användarnamn och lösenord matchar inte";

  // Causes of redirect made without checking of form, alt: Misc
  const ACCESS_LOGGED_IN_NO = "Du måste vara inloggad för att komma åt den sidan";
  const TOKEN_INVALID = "Din pollet är inte giltig";
  const EMAIL_VERIFIED_NO = "Din e-postadress har inte blivit verifierad än, var god verifiera din e-postadress";
}
