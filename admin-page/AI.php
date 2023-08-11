

<?php

class ChatGPT
{
    private $API_KEY = "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";
    private $textURL = "https://api.openai.com/v1/completions";
    private $imageURL =  "https://api.openai.com/v1/images/generations";

    public $curl;       // create cURL object
    public $data = [];  // data request array

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function initialize($requestType = "text" || "image")
    {
        $this->curl = curl_init();

        if ($requestType === 'image')
            curl_setopt($this->curl, CURLOPT_URL, $this->imageURL);
        if ($requestType === 'text')
            curl_setopt($this->curl, CURLOPT_URL, $this->textURL);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POST, true);

        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $this->API_KEY"
        );

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    }

    // returns text
    public function createTextRequest($prompt, $model = 'text-davinci-003', $temperature = 0.5, $maxTokens = 1000)
    {
        curl_reset($this->curl);
        $this->initialize('text');

        $this->data["model"] = $model;
        $this->data["prompt"] = $prompt;
        $this->data["temperature"] = $temperature;
        $this->data["max_tokens"] = $maxTokens;

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->data));

        $response = curl_exec($this->curl);
        $response = json_decode($response, true);
        return $response["choices"][0]["text"]; // return text or -1 if error
    }

    // returns URL with the image
    public function generateImage($prompt, $imageSize = '512x512', $numberOfImages = 1)
    {
       // OpenAI API endpoint
        $api_endpoint = 'https://api.openai.com/v1/images/generations';

    // OpenAI API key
    $api_key = $this->API_KEY;


    // Request headers
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
    ];

    // Request data
    $data = [
        'model' => 'image-alpha-001', // DALL-E 2
        'prompt' => $prompt,
        'num_images' => $numberOfImages,
        'size' => $imageSize,
    ];

    // Send request to OpenAI API
    $curl = curl_init($api_endpoint);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);

    // Decode response JSON
    $response_data = json_decode($response, true);

    // Get image data from response
    $image_data = $response_data['data'][0]['url'];

    // Save image to file
    $image_content = file_get_contents($image_data);
    file_put_contents('cat.png', $image_content);
            return $image_data; 
            
        }
    }

$testObject = new ChatGPT();

if(isset ($_POST["action"])){
    $action = $_POST["action"];
    switch($action){
        case "create_title":
            $title =  $testObject->createTextRequest("write a title for my plant blog");
            echo $title;
            break;
        case "create_image":
            $title = $_POST["title"];
            $image = $testObject->generateImage($title) ;
            echo $image;
            break;
            case "create_content":
                $title = $_POST["title"];
                $content = $testObject->createTextRequest("write a blog for title: " . $title) ;
                echo $content;
                break;

    }
   
}

// echo $testObject->createTextRequest("viết cho tôi một đoạn 1000");
// echo '<br>';
// echo $testObject->generateImage("plant out door") ;
?>

