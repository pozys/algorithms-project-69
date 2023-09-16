<?php

namespace App;

function search(array $docs, string $search): array
{
    $data = prepareData($docs);

    $searchedWords = prepareSearch($search);

    $found = searchForWords($data, $searchedWords);

    $sorted = sortByRelevance($found);

    return array_keys($sorted);
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
                if (in_array($doc['id'], array_column($accum[$term], 'id'))) {
                    continue;
                }

                $accum[$term] = [
                    ...$accum[$term],
                    [...$doc, 'id' => $doc['id'], 'tf' => getTermFrequency($doc['terms'], $term)]
                ];
            } else {
                $accum[$term] = [
                    [
                        ...$doc,
                        'id' => $doc['id'],
                        'tf' => getTermFrequency($doc['terms'], $term),
                    ]
                ];
            }
        }

        return $accum;
    }, []);

    $idf = array_map(
        fn (array $docsWithWord): array => [
            'docs' => $docsWithWord,
            'idf' => count($docsWithWord) === 0 ? 0 : log(count($docs) / count($docsWithWord)),
        ],
        $invertedIndex
    );

    $tfidf = array_map(
        fn (array $docs): array => [
            ...$docs,
            'docs' => array_map(
                fn (array $doc) => [...$doc, 'tfidf' => $doc['tf'] * $docs['idf']],
                $docs['docs']
            ),
        ],
        $idf
    );

    return $tfidf;
}

function getTermFrequency(array $terms, string $word): float
{
    $occurrencesNumber = count(array_filter($terms, fn (string $term) => $term === $word));
    $termsCount = count($terms);

    return $termsCount === 0 ? 0 : $occurrencesNumber / $termsCount;
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
    return array_reduce(
        $words,
        fn (array $accum, string $word) => [...$accum, [...$docs[$word]]],
        []
    );
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
    $docs = array_column($docs, 'docs');

    $totaltfidf = array_reduce(
        $docs,
        function (array $accum, array $doc) {
            foreach ($doc as ['id' => $id, 'tfidf' => $tfidf]) {
                if (array_key_exists($id, $accum)) {
                    $accum[$id] += $tfidf;
                } else {
                    $accum[$id] = $tfidf;
                }
            }

            return $accum;
        },
        []
    );

    arsort($totaltfidf);

    return $totaltfidf;
}
