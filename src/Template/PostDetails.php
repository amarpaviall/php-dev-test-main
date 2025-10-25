<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostDetails extends Layout
{
    protected function renderPage(Context $context): string
    {
        $title = htmlspecialchars($context->post->title);
        $author = htmlspecialchars($context->post->author);

        return <<<HTML
            <!-- <p>SHOW CONTENT FOR {$context->content} HERE</p> -->
            <h1>{$title}</h1>
            <p><em>by {$author}</em></p>
            HTML;
    }
}
