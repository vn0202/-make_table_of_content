<?php
require "../vendor/autoload.php";
use Vannghia\MakeTableOfContent\GenerateTOC;
use Symfony\Component\DomCrawler\Crawler;
// get HTML string  from document;
// This is demo HTML after you handle and get contbet
$html = <<< EOF
 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, sunt.</p>
  <h2 id="heading-2">This is heading 2</h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi cumque ducimus iste possimus veniam! Animi
      cupiditate fugiat molestiae tenetur vel?</p>
  <h3 id="heading-3">This is heading 3</h3>
<h3 id="heading-3-1">This is heading 3</h3>
<h4 id="heading-4">This is heading 4</h4>
  <h4 id="heading-4-1">This is heading 4</h4>
  <h2 id="heading-2-1">This is heading 2</h2>
  <h2 id="heading-2-2">This is heading 2</h2>
EOF;
$menu =  GenerateTOC::generateMenu($html);
$text = GenerateTOC::generateTableFromContent($html);
print_r($text);