<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostIndex extends Layout
{
    protected function renderPage(Context $context): string
    {
        $html = "<h1>" . htmlspecialchars($context->title) . "</h1>";
        $html .= "<span>" . "Total Posts : " . $context->content. "</span>";
        $html .= <<<HTML

            HTML;
        return $html;
    }
}
