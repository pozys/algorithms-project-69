<?php

namespace App;

function search(array $docs, string $search): array
{
    $splitted = array_map(fn (array $doc) => [...$doc, ...['text' => str_word_count($doc['text'], 2)]], $docs);
    $termes = array_map(fn (array $split) => [
        ...$split,
        ...['text' => array_map(
            fn (string $word) => getTerm($word),
            $split['text']
        )]
    ], $splitted);

    $filtered = array_filter($termes, fn (array $doc) => array_search(getTerm($search), $doc['text']) !== false);

    return array_map(fn (array $doc) => $doc['id'], $filtered);
}

function getTerm(string $token): string
{
    $matches = [];
    preg_match_all('/\w+/', $token, $matches);

    return $matches[0][0] ?? '';
}
