<?php

namespace App\Tasks;

class TaskGroup
{
    private $tasks;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->tasks = collect();
    }

    public function add(AbstractTask $task)
    {
        $this->tasks->push($task);
    }

    public function run()
    {
        $this->output("<h1>{$this->title}</h1>");
        $this->output('<hr>');

        $this->output('<ul>');
        $this->tasks->each(function ($task) {
            $task->run();

            $status = $task->passed() ? 'success' : 'fail';

            $this->output("<li>{$task->title()} - {$status}</li>");
        });
        $this->output('</ul>');

        $this->output("<h1>{$this->title} - done</h1>");
        $this->output('<hr>');
    }

    protected function output(string $output, bool $lineBreak = false, bool $newline = true)
    {
        echo $output . ($lineBreak ? '<br />' : '') . ($newline ? "\n" : '');
    }
}
