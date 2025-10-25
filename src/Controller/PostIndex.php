<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Template;

class PostIndex extends Controller
{
    /**
     * @var array<Post>
     */
    private array $posts = [];

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Posts';
        $context->content = strval(count($this->posts));
        $context->posts = $this->posts;
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\PostIndex();
    }

    protected function loadData(): void
    {
        // TODO: Load posts from database here.
        //$this->posts = [];

        // Fetch published posts in reverse chronological order
        $stmt = $this->db->prepare('
            SELECT p.id, p.title, p.body, p.created_at, p.modified_at, a.full_name AS author
            FROM posts p
            LEFT JOIN authors a ON p.author = a.id
            ORDER BY p.created_at DESC
        ');

        $stmt->execute();

        $this->posts = $stmt->fetchAll(\PDO::FETCH_CLASS, Post::class);
    }
}
