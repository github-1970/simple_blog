<?php
function textWrapper($text, $count=50){
  return strlen($text) - 3 > $count ? mb_substr($text, 0, $count, 'utf-8') . ' ...' : $text;
}
