<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostIndex extends Layout
{
    protected function renderPage(Context $context): string
    {
        $html = "<h1 class='page-title'>" . htmlspecialchars($context->title) . "</h1>";
        $html .= "<span class='post-count'>" . "Total Posts : " . $context->content. "</span>";
        if (!empty($context->posts) && is_array($context->posts)) {
            $html .= "<ul class='post-list'>";

            foreach ($context->posts as $post) {
                if (!$post) continue;

                $id = urlencode($post->id ?? '');
                $title = htmlspecialchars($post->title ?? '');
                $author = htmlspecialchars($post->author ?? '');
                $date =  htmlspecialchars(date('F j, Y', strtotime($post->created_at) ?? ''));

                $html .= <<<HTML
                <li>
                    <a href="/posts/{$id}">{$title}</a>
                    <div class="post-meta">
                        <span class="author">Author :  {$author}</span>
                        <span class="date">Date : {$date}</span>
                    </div>
                </li>
                HTML;
            }
                $html .= "</ul>";
            } else {
                $html .= "<p>No posts found.</p>";
            }
        return $html;
    }
}
