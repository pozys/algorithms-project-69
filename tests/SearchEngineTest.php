<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function App\search;

class SearchEngineTest extends TestCase
{
    public function testSearch(): void
    {
        $doc1 = "I can't shoot straight unless I've had a pint!";
        $doc2 = "Don't shoot shoot shoot that thing at me.";
        $doc3 = "I'm your shooter.";

        $docs = [
            ['id' => 'doc1', 'text' => $doc1],
            ['id' => 'doc2', 'text' => $doc2],
            ['id' => 'doc3', 'text' => $doc3],
        ];

        $expected = ['doc1', 'doc2',];

        $this->assertEquals($expected, search($docs, 'shoot'));
    }
}
