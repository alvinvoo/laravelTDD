<?php

function gravatar_url($email)
{
  $email = md5($email);
  return "https://gravatar.com/avatar/{$email}?".http_build_query([
    's'=> 60,
    'd'=> 'https://static1.squarespace.com/static/5829f47bc534a550aa05b425/595c18ce365ffa3396a55cd6/595c1a13365ffa3396a5b256/1500148825293/does-kim-kardashian-have-breast-implants.jpg'
  ]);
}