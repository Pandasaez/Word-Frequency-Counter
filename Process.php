<?php
    // stop words filter out
    $stopWords = [
        "the", "and", "in", "of", "to", "a", "is", "it", "that", "this", "on", "for", "with", "as", "was", "at", "by", "an", "be", "or"
    ];

    //clean tokenize text
    function tokenizeText($text, $stopWords) {
        $text = strtolower($text); // Convert to lowercase
        $text = preg_replace('/[^a-z\s]/', '', $text); // Remove punctuation
        $words = explode(" ", $text); // Split text into words
        $filteredWords = array_diff($words, $stopWords); // Remove stop words
        return array_filter($filteredWords); // Remove empty values
    }

    //count word frequencies
    function countWordFrequencies($words) {
        return array_count_values($words);
    }

    // Tokenize text and count frequencies
    $words = tokenizeText($inputText, $stopWords);
    $wordFrequencies = countWordFrequencies($words);

    // Sort
    if ($sortOrder === "asc") {
        asort($wordFrequencies);
    } else {
        arsort($wordFrequencies);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $inputText = $_POST["text"];
        $sortOrder = $_POST["sort"];
        $limit = intval($_POST["limit"]);

    // Limit results
    $wordFrequencies = array_slice($wordFrequencies, 0, $limit, true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Results</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Word Frequency Results</h1>
    <table border="1" style="margin: auto; text-align: center;">
        <tr>
            <th>Word</th>
            <th>Frequency</th>
        </tr>
        <?php if (!empty($wordFrequencies)) : ?>
            <?php foreach ($wordFrequencies as $word => $count) : ?>
                <tr>
                    <td><?= htmlspecialchars($word); ?></td>
                    <td><?= $count; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="2">No words HAHAHAHAH.</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
    <a href="index.php" class="back-btn">Back</a>
</body>
</html>
