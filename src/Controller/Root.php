<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;

class Root extends Controller
{
    protected ?string $message = null;

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Welcome';
        $context->message = $this->message;
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\Root();
    }

    protected function loadData(): void
    {
        // Run only when the import button is clicked
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import'])) {
            $this->message = $this->importPosts();
        }
    }

    public function importPosts(): string
    {
        $dataFolder = __DIR__ . '/../../data';
           // echo $dataFolder;
        $files = glob($dataFolder . '/*.json');
        $imported = 0;
        foreach ($files as $file) {
            $json = file_get_contents($file);
            $postData = json_decode($json, true);

            if (!$postData) {
                echo "Skipping invalid file: $file\n";
                continue;
            }

            // Skip if already exists
        $exists = $this->db->prepare("SELECT 1 FROM Posts WHERE id = :id");
        $exists->execute([':id' => $postData['id']]);
        if ($exists->fetch()) continue;

            $stmt = $this->db->prepare("
                INSERT INTO Posts (id, title, body, created_at, modified_at, author)
                VALUES (:id, :title, :body, :created_at, :modified_at, :author)
            ");

            try {
                $stmt->execute([
                    ':id' => $postData['id'],
                    ':title' => $postData['title'],
                    ':body' => $postData['body'],
                    ':created_at' => $postData['created_at'],
                    ':modified_at' => $postData['modified_at'],
                    ':author' => $postData['author'],
                ]);
                $imported++;
                //echo "Imported post: " . $postData['title'] . "\n";
            } catch (\PDOException $e) {
                echo "Failed to import {$postData['title']}: " . $e->getMessage() . "\n";
            }
        }
        $message = "✅ Imported {$imported} posts.";

        return $message;
    }
}
