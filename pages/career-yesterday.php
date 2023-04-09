<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;

// $zodiacsign = "Leo";
function generateHoroscope($sign)
{
    // API endpoint and parameters
    $endpoint = 'https://api.openai.com/v1/completions';
    $apiKey = '<PLACE YOUR CHAT GPT API KEY HERE>';
    $model = 'text-davinci-002';
    $text = "Write 2 paragraphe daily horoscope for $sign related to career";
    $parameters = [
        'prompt' => $text,
        'temperature' => 0.7,
        'max_tokens' => 400,
        'n' => 1,
        'stop' => '\n'
    ];

    // Send request to API

    $client = new \GuzzleHttp\Client();
    try {
        $response = $client->post($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey
            ],
            'json' => [
                'model' => $model,
                'prompt' => $text,
                'temperature' => $parameters['temperature'],
                'max_tokens' => $parameters['max_tokens'],
                'n' => $parameters['n'],
                'stop' => $parameters['stop']
            ]
        ]);
        // Get completion from response
        $completion = json_decode($response->getBody(), true)['choices'][0]['text'];
        // Output completion
        // echo $completion . "<br><br><br><br>";

        // Extract different parts of a string
        $string = $completion;
        // $string = str_replace("--END--", "", $string);
        // $parts = explode("--START--", $string);

        $last_updated = date('Y-m-d');
        // array_unshift($parts, $last_updated);

        // Write parts in a json file as an array
        $json = file_get_contents("../signs/$sign.json");
        $data = json_decode($json, true);
        $data['career-date'] = $last_updated;


        $data['career-yesterday'] = $data['career-today'];
        $data['career-today'] = $data['career-tomorrow'];
        $data['career-tomorrow'] = $string;

        // $data = array(
        //   'date' => $last_updated,
        //   'yesterday' =>  $string,
        //   // 'today' =>  $parts[3],
        //   // 'tomorrow' =>  $parts[4]
        // );

        $json_string = json_encode($data, JSON_PRETTY_PRINT);

        // Write the JSON string to a file
        if (isset($completion)) {
            file_put_contents("../signs/$sign.json", $json_string);
        }
    } catch (Exception $e) {
        // Handle error
        echo 'Error: ' . $e->getMessage();
    }
}





// Get the type of horoscope sign from index.html input
if (isset($_POST["zodiacsign"])) {
    $zodiacsign = $_POST["zodiacsign"];
}

$json_string = file_get_contents("../signs/$zodiacsign.json");
$horoscope = json_decode($json_string, true);
//Check the updated date of zodiacsign.json
$lastupdated = $horoscope["career-date"];
$lastupdated = strtotime($lastupdated);
$lastupdated = date('Y-m-d', $lastupdated); // Output: 2022-04-05


$today = date('Y-m-d');

if ($lastupdated >= $today) {
    // echo "The date in $lastupdated is earlier than or equal today's $today.";
} else {
    // echo "The date in $lastupdated is the same or later than today's $today.";

    // Call function here
    generateHoroscope($zodiacsign);
}





?>

<?php require_once("header.php") ?>
<form id="hiddenformforward" method="post" action="career.php">
    <input type="hidden" name="zodiacsign" value="<?= $zodiacsign ?>">
</form>

<!-- ======= Services Section ======= -->
<section id="services" class="services section-bg">
    <div class="container">

        <div class="section-title">
            <h2>Horoscope</h2>
            <p>Your horoscope is here <?= $zodiacsign ?></p>
        </div>

        <div class="row">
            <div class="col-md-2 col-lg-2 col-sm-2 col-2 d-flex align-items-stretch" data-aos="zoom-in"
                data-aos-delay="100">
                <!-- <a href="#" class="right-left-arrow d-flex align-items-center justify-content-center"
                    style="margin-inline: auto;"><i class="bi bi-arrow-left-short"></i></a> -->
            </div>

            <div class="col-md-8 col-lg-8 col-sm-8 col-8 d-flex align-items-stretch" data-aos="zoom-in"
                data-aos-delay="200">
                <div class="icon-box">
                    <!-- <div class="icon"><i class="bx bx-file"></i></div> -->
                    <h4 class="title">Yesterday's Horoscope</h4>
                    <p class="description"><?= $horoscope["career-yesterday"] ?></p>
                    <br><br><br>
                    <a class="button-custom" style="margin-left: 0px;" href="../index.html">Check out more</a>
                </div>
            </div>

            <div class="col-md-2 col-lg-2 col-sm-2 col-2 d-flex align-items-stretch" data-aos="zoom-in"
                data-aos-delay="300">
                <a href="#" class="right-left-arrow d-flex align-items-center justify-content-center"
                    style="margin-inline: auto;"
                    onclick="document.getElementById('hiddenformforward').submit(); return false;"><i
                        class="bi bi-arrow-right-short"></i></a>
            </div>

        </div>

    </div>
</section><!-- End Services Section -->

<script>
window.onload = function() {
    var section = document.getElementById("services");
    section.scrollIntoView({
        behavior: "smooth",
        block: "start",
        inline: "nearest"
    });
};
</script>
<?php require_once("footer.php") ?>