<?php
function bbCodesReplace($text) {
  $codesToReplace = array(
    '~\[b\](.*?)\[/b\]~s',
    '~\[i\](.*?)\[/i\]~s',
    '~\[u\](.*?)\[/u\]~s',
    '~\[quote\](.*?)\[/quote\]~s'
  );

  $changeTo = array(
    '<b>$1</b>',
    '<i>$1</i>',
    '<span style="text-decoration:underline;">$1</span>',
    '<pre>$1</'.'pre>'
  );

  return preg_replace($codesToReplace, $changeTo, $text);
}
