<?php
namespace Vannghia\MakeTableOfContent;
use Symfony\Component\DomCrawler\Crawler;
class GenerateTOC
{

    public static function generateMenu(string $content)
    {
        $heading_tag = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        $crawler = new Crawler();
        $crawler->addHtmlContent($content);
        $menu = [];
        $prev = null;
        $parent = null;
        $crawler->filter(implode(',', $heading_tag))->each(function (Crawler $node) use (&$menu, &$prev, &$parent) {
            $pattern = "/h(\d+)/";
            preg_match($pattern, $node->nodeName(), $matches);
            $level = $matches[1];
            if (!$prev) {
                $prev = new \stdClass();
                $prev->tagName = $node->nodeName();
                $prev->text = $node->text();
                $prev->id = $node->attr('id');
                $prev->level = $level;
                $prev->parent = null;
                $prev->child = [];
                array_push($menu, $prev);
                $prev = $menu[count($menu) - 1];
            } else {
                $currentLevel = $level;
                $prevLevel = $prev->level;
                if ($prevLevel < $currentLevel) {
                    $parent = $prev;
                    $prev = new \stdClass();
                    $prev->tagName = $node->nodeName();
                    $prev->text = $node->text();
                    $prev->id = $node->attr('id');
                    $prev->level = $level;
                    $prev->child = [];
                    $prev->parent = $parent;

                    $parent->child[] = $prev;
                } elseif ($prevLevel == $currentLevel) {
                    if (!$parent) {
                        $prev = new \stdClass();
                        $prev->tagName = $node->nodeName();
                        $prev->text = $node->text();
                        $prev->id = $node->attr('id');
                        $prev->level = $level;
                        $prev->parent = null;
                        $prev->child = [];
                        array_push($menu, $prev);
                        $prev = $menu[count($menu) - 1];
                    } else {
                        $prev = new \stdClass();
                        $prev->tagName = $node->nodeName();
                        $prev->text = $node->text();
                        $prev->id = $node->attr('id');
                        $prev->level = $level;
                        $prev->child = [];
                        $prev->parent = $parent;
                        $parent->child[] = $prev;
                    }

                } elseif ($prevLevel > $currentLevel) {
                    while ($parent && $parent->level >= $currentLevel) {
                        $parent = $parent->parent;
                    }
                    if (!$parent) {
                        $prev = new \stdClass();
                        $prev->tagName = $node->nodeName();
                        $prev->text = $node->text();
                        $prev->id = $node->attr('id');
                        $prev->level = $level;
                        $prev->parent = null;
                        $prev->child = [];
                        array_push($menu, $prev);
                        $prev = $menu[count($menu) - 1];
                    } else {
                        $prev = new \stdClass();
                        $prev->tagName = $node->nodeName();
                        $prev->text = $node->text();
                        $prev->id = $node->attr('id');
                        $prev->level = $level;
                        $prev->child = [];
                        $prev->parent = $parent;
                        $parent->child[] = $prev;
                    }

                }
            }
        });
        return $menu;
    }
    public static function generateTableFromContent(string $content)
    {
        $menus = self::generateMenu($content);

        if(count($menus))
        {
            return self::generateTable($menus);
        }
    }

    public static function generateTable(array $menu )
    {
        if (empty($menu)) {
            return '';
        }
        $html = '<ul>';
        foreach ($menu as $item) {
            $html .= "<li><a href='#{$item->id}'>";
            $html .= $item->text;

            if (!empty($item->child)) {
                $html .= self::generateTable($item->child);
            }
            $html .= '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}