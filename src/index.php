<?php

namespace App;

function search(array $docs, string $search): array
{
    $splitted = array_map(fn (array $doc) => [...$doc, ...['text' => explode(' ', $doc['text'])]], $docs);
    $filtered = array_filter($splitted, fn (array $doc) => array_search($search, $doc['text']) !== false);

    return array_map(fn (array $doc) => $doc['id'], $filtered);
}
