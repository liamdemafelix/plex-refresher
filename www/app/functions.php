<?php

require __DIR__ . '/../vendor/autoload.php';

// Load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$dotenv->required('PLEX_SSL')->isBoolean();
$dotenv->required(['PLEX_ENDPOINT', 'PLEX_USERNAME', 'PLEX_PASSWORD'])->notEmpty();
$dotenv->required('PLEX_PORT')->isInteger();

function sendResponse($status = 200, $message = "", $data = [])
{
    http_response_code($status);
    echo json_encode([
        'message' => $message,
        'data' => $data
    ]);
    exit();
}

function getPlexClient()
{
    $client = new jc21\PlexApi($_ENV['PLEX_ENDPOINT'], $_ENV['PLEX_PORT'], $_ENV['PLEX_SSL']);

    // Check if we already have a saved token
    $tokenFile = __DIR__ . '/../.token';
    if (!is_file($tokenFile) || empty(trim(file_get_contents($tokenFile)))) {
        $client->setAuth($_ENV['PLEX_USERNAME'], $_ENV['PLEX_PASSWORD']);
        @unlink($tokenFile);
        file_put_contents($tokenFile, $client->getToken());
    } else {
        // Read the saved token
        $token = file_get_contents($tokenFile);
        $client->setToken($token);
        if (!$client->getBaseInfo()) {
            // Our token is wrong, log in again.
            $client->setAuth($_ENV['PLEX_USERNAME'], $_ENV['PLEX_PASSWORD']);
            @unlink($tokenFile);
            file_put_contents($tokenFile, $client->getToken());
        }
    }

    return $client;
}

function loadLibraries()
{
    $libraries = getPlexClient()->getLibrarySections();
    if (!$libraries) {
        throw new Exception("Failed to load libraries.");
    }

    $data = [];
    foreach ($libraries['Directory'] as $item) {
        $data[] = [
            'id' => $item['key'],
            'text' => $item['title']
        ];
    }

    usort($data, function ($x, $y) {
        return $x['text'] <=> $y['text'];
    });

    return $data;
}

function loadItems($key)
{
    $content = getPlexClient()->getLibrarySectionContents($key);
    if (!$content) {
        throw new Exception("Failed to load library contents.");
    }

    $data = [];
    if (array_key_exists('Video', $content)) {
        foreach ($content['Video'] as $item) {
            $data[] = [
                'id' => $item['ratingKey'],
                'text' => $item['title']
            ];
        }
    } else {
        foreach ($content['Directory'] as $item) {
            $data[] = [
                'id' => $item['ratingKey'],
                'text' => $item['title']
            ];
        }
    }

    usort($data, function ($x, $y) {
        return $x['text'] <=> $y['text'];
    });

    return $data;
}

function refresh($key)
{
    return getPlexClient()->refreshMetadata($key, true);
}