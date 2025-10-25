<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model;
use silverorange\DevTest\Model\Post;

class PostDetails extends Controller
{
    /**
     * TODO: When this property is assigned in loadData this PHPStan override
     * can be removed.
     *
     * @phpstan-ignore property.unusedType
     */
    private ?Model\Post $post = null;

    public function getContext(): Context
    {
        $context = new Context();

        if ($this->post === null) {
            $context->title = 'Not Found';
            $context->content = "A post with id {$this->params[0]} was not found.";
        } else {
            $context->title = $this->post->title;
            $context->content = $this->params[0];
        }

        return $context;
    }

    public function getTemplate(): Template\Template
    {
        if ($this->post === null) {
            return new Template\NotFound();
        }

        return new Template\PostDetails();
    }

    public function getStatus(): string
    {
        if ($this->post === null) {
            return $this->getProtocol() . ' 404 Not Found';
        }

        return $this->getProtocol() . ' 200 OK';
    }

    protected function loadData(): void
    {
        // TODO: Load post from database here. $this->params[0] is the post id.
        //$this->post = null;

        $id = $this->params[0];

         // Fetch post with author using postId
        $stmt = $this->db->prepare('
            SELECT p.id, p.title, p.body, p.created_at, p.modified_at, a.full_name AS author
            FROM posts p
            LEFT JOIN authors a ON p.author = a.id
            WHERE p.id = :id
        ');

        $stmt->execute(['id' => $id]);

        $this->post = $stmt->fetchObject(Post::class) ?: null;
    }
}
