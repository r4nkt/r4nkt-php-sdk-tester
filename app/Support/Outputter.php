<?php

namespace App\Support;

class Outputter
{
    protected function output(string $output, bool $lineBreak = true, bool $newLine = true)
    {
        echo $output . ($lineBreak ? '<br />' : '') . ($newLine ? '\n' : '');
    }
}
