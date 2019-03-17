<?php
/*
Plugin Name: ADD GA TAG
Author Name: Miren  Cava

// Hook the 'wp_head' action hook, add the function named 'setGA' to it
add_action("wp_head", "setGA");


function setGA()
{
  echo '<!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136408159-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());
    gtag("config", "UA-136408159-1");
  </script>'; 

}