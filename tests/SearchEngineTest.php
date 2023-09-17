<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function App\search;

class SearchEngineTest extends TestCase
{
    private array $docs;
    protected function setUp(): void
    {
        $doc1 = "I can't shoot straight unless I've had a pint!";
        $doc2 = "Don't shoot shoot shoot that thing at me.";
        $doc3 = "I'm your shooter.";
        $this->docs = [
            ['id' => 'doc1', 'text' => $doc1],
            ['id' => 'doc2', 'text' => $doc2],
            ['id' => 'doc3', 'text' => $doc3],
        ];
    }
    public function testSimpleSearch(): void
    {
        $expected = ['doc2', 'doc1',];

        $this->assertEquals($expected, search($this->docs, 'shoot straight'));
    }
}
