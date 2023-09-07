<?php

namespace App;

function search(array $docs, string $search): array
{
    $tokenized = array_map(fn (array $doc) => [
        ...$doc, 'tokens' => tokenize($doc['text'])
    ], $docs);

    $termes = array_map(fn (array $split) => [
        ...$split,
        'termes' => array_map(
            fn (string $word) => getTerm($word),
            $split['tokens']
        )
    ], $tokenized);

    $searched = array_map(
        fn ($doc) => [
            ...$doc,
            'search' => array_filter($doc['termes'], fn (string $word) => $word === getTerm($search))
        ],
        $termes
    );

    $filtered = array_filter(
        $searched,
        fn (array $doc) => count($doc['search']) > 0
    );

    $sorted = sortByRelevance($filtered);

    return array_column($sorted, 'id');
}

function getTerm(string $token): string
{
    $matches = [];
    preg_match_all('/\w+/', $token, $matches);

    return $matches[0][0] ?? '';
}

function tokenize(string $text): array
{
    return str_word_count($text, 2);
}

function sortByRelevance(array $docs): array
{
    $counted = array_map(fn (array $doc) => [...$doc, 'count' => count($doc['search'])], $docs);
    usort($counted, fn (array $doc1, array $doc2) => $doc1['count'] <=> $doc2['count']);

    return array_reverse($counted);
}
