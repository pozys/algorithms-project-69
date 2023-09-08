<?php

namespace App;

function search(array $docs, string $search): array
{
    $data = prepareData($docs);

    $searchedWords = prepareSearch($search);

    $found = searchForWords($data, $searchedWords);

    return sortByRelevance($found);
    // print_r($sorted);
    // return array_column($sorted, 'id');
}

function prepareData(array $docs): array
{
    $tokenized = array_map(fn (array $doc) => [
        ...$doc, 'tokens' => tokenize($doc['text'])
    ], $docs);

    $terms = array_map(fn (array $split) => [
        ...$split,
        'terms' => array_map(
            fn (string $word) => getTerm($word),
            $split['tokens']
        )
    ], $tokenized);

    $invertedIndex = array_reduce($terms, function (array $accum, array $doc): array {
        foreach ($doc['terms'] as $term) {
            if (array_key_exists($term, $accum)) {
                $accum[$term] = array_unique([...$accum[$term], $doc['id']]);
            } else {
                $accum[$term] = [$doc['id']];
            }
        }

        return $accum;
    }, []);

    return $invertedIndex;
}

function prepareSearch(string $search): array
{
    return array_map(
        fn (string $word) => getTerm($word),
        tokenize($search)
    );
}

function searchForWords(array $docs, array $words): array
{
    // $found = array_map(
    //     fn ($doc) => [
    //         ...$doc,
    //         'found' => array_filter($doc['terms'], fn (string $word) => in_array($word, $words))
    //     ],
    //     $docs
    // );

    return array_reduce(
        $words,
        fn (array $accum, string $word) => array_unique([...$accum, ...$docs[$word]]),
        []
    );

    // return array_filter(
    //     $found,
    //     fn (array $doc) => count($doc['found']) > 0
    // );
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
    sort($docs);
    return $docs;
    // $counted = array_map(fn (array $doc) => [
    //     ...$doc,
    //     'count' => count($doc['found']),
    //     'found_count' => count(array_unique($doc['found']))
    // ], $docs);

    // usort(
    //     $counted,
    //     fn (array $doc1, array $doc2) =>
    //     $doc1['found_count'] === $doc2['found_count']
    //         ? $doc1['count'] <=> $doc2['count']
    //         : $doc1['found_count'] <=> $doc2['found_count']
    // );

    // return array_reverse($counted);
}
