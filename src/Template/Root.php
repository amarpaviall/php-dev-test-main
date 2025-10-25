<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class Root extends Layout
{
    protected function renderPage(Context $context): string
    {
        $messageHtml = '';
        if (!empty($context->message)) {
            $messageHtml = <<<HTML
                <div class="alert alert-success">
                    {$context->message}
                </div>
            HTML;
        }

        return <<<HTML

            <p>Things are up and running—you’ve got this!</p>
            {$messageHtml}
            <form method="post" action="/">
                <button type="submit" name="import" value="1" class="button">
                    Import Posts
                </button>
            </form>

            HTML;
    }
}
