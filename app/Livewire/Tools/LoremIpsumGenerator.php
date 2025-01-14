<?php

namespace App\Livewire\Tools;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

use function implode;
use function rand;
use function shuffle;

class LoremIpsumGenerator extends Component
{
    public $paragraphs = 1;
    public $loremIpsumText = '';

    private array $words = [
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur',
        'adipiscing', 'elit', 'sed', 'do', 'eiusmod', 'tempor',
        'incididunt', 'ut', 'labore', 'et', 'dolore', 'magna', 'aliqua'
    ];

    /**
     * Generate a single sentence with a random number of words.
     */
    private function generateSentence(): string
    {
        shuffle($this->words); // Shuffle the words array

        $wordCount = rand(5, min(30, count($this->words)));

        $sentence = collect($this->words)
            ->take($wordCount)
            ->implode(' ');

        return ucfirst($sentence) . '.';
    }

    /**
     * Generate a single paragraph with a random number of sentences.
     */
    private function generateParagraph(): string
    {
        $sentenceCount = rand(3, 7);
        return collect(range(1, $sentenceCount))
            ->map(fn() => $this->generateSentence())
            ->implode(' ');
    }

    /**
     * Generate a heading.
     */
    private function generateHeading(int $level = 2): string
    {
        shuffle($this->words); // Shuffle the words array

        $headingText = collect($this->words)
            ->take(rand(3, 7))
            ->implode(' ');

        return "<h{$level}>" . ucfirst($headingText) . "</h{$level}>";
    }

    /**
     * Generate Lorem Ipsum text based on the number of paragraphs.
     */
    public function generateLoremIpsum(): void
    {
        $content = [];
        $headingInterval = rand(2, 4);

        for ($i = 1; $i <= $this->paragraphs; $i++) {
            $content[] = $this->generateParagraph();

            // Add a heading every 2 to 4 paragraphs, but not after the last paragraph
            if (($i % $headingInterval === 0) && ($i < $this->paragraphs)) {
                $content[] = $this->generateHeading();
                $headingInterval = rand(2, 4);
            }
        }

        $this->loremIpsumText = implode("\n\n", $content);
    }

    /**
     * Render the Livewire component.
     */
    public function render(): Application|Factory|View
    {
        return view('livewire.tools.lorem-ipsum-generator');
    }
}
