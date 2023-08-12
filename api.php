<?php

$apiKey = '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';

$userMessage = json_decode(file_get_contents('php://input'))->userMessage;

$trainingData = [
    [
        "question" => "I want to learn how to take care of houseplants.",
        "answer" => "- Taking care of houseplants involves several key aspects:\n
        - Providing Adequate Water: One of the most important aspects of caring for houseplants is providing the right amount of water. Understand whether your plant prefers moist or dry conditions. Plants that prefer moist conditions need more water, while succulent plants need less frequent watering. You can check the soil's moisture level by touching it or observing its color.",
    ],
    [
        "question" => "Làm sao để chăm sóc cây cảnh?",
        "answer" => "Cần tưới nước đều đặn, đặt cây ở nơi có ánh sáng mặt trời vừa phải và thay đổi đất đỏ sau một thời gian.",
    ],
    [
        "question" => "Should pesticides be used?",
        "answer" => "You should use your own pesticides that can stimulate antibiotic resistance and protect plants optimally. This drug is resistant to harmful organisms and decomposes within the time allowed to ensure the best technical and health factors.",
    ],
    [
        "question" => "How to take care of bonsai during the cold winter months?",
        "answer" => "YDuring the winter, plants should be placed near a window to take advantage of sunlight. Avoid placing plants near heat sources such as fireplaces. Depending on the type of plant, you can adjust the frequency of watering to avoid over-wetting the soil.",
    ],
    [
        "question" => "How do bonsai need to fertilize the soil?",
        "answer" => "Most ornamental plants need a well-draining soil. You can use compost containing organic matter to improve soil structure and drainage. Make sure the pot has drainage holes to avoid waterlogging.",
    ],
    [
        "question" => "Can the tree be transported long distances?",
        "answer" => "Sure! We offer nationwide delivery to ensure your crops arrive safely and quickly. We will ensure that the tree is carefully packed to avoid loss during transit.
        ",
    ],
    [
        "question" => "How many different types of cacti are you offering on your website?",
        "answer" => "We currently offer a wide range of cacti, from small varieties that are easy to grow indoors to larger varieties suitable for the garden. You can discover different types of cacti on our website.",
    ],
    [
        "question" => "Stone lotus is an ornamental plant that can live in what conditions?",
        "answer" => "Stone lotus is a drought tolerant plant and good light. They grow well in direct sunlight or scattered light. It is important to limit over-watering to avoid over-wetting the soil.",
    ],
    [
        "question" => "Can your plants be grown both indoors and outdoors?",
        "answer" => "That's right, we offer a wide variety of ornamental plants that can be grown both indoors and outdoors. Depending on the type of tree, we can advise you on the best care and placement.",
    ],
    [
        "question" => "How to properly care for cactus?",
        "answer" => "Cactus plants generally require little water and are tolerant of smoke and harsh environments. Let the soil dry completely before watering again. During winter, reduce the frequency of watering. Place the plant in a place with direct sunlight or bright light.",
    ],
    [
        "question" => "What preparation is required to successfully grow ornamental plants?",
        "answer" => "To grow bonsai successfully, you need to choose the right pot for the size of the plant, use potting soil or dilute the garden soil and add the necessary fertilizer. Make sure the plant is placed in a location with proper lighting and regular care.",
    ],
    [
        "question" => "Is there a way to prevent and treat pests and diseases on this plant?",
        "answer" => "To prevent pests and diseases, you can inspect the plant regularly and remove infested leaves. If the condition becomes severe, you can safely use a worm control product.",
    ],
    [
        "question" => "I'm looking for an air-purifying flower plant. Are any of your categories relevant?",
        "answer" => "Of course! We have a range of plants like Aloe Vera that clean the air by removing harmful substances from your living space.",
    ],
    [
        "question" => "Any tips for creating an interesting and unique garden?",
        "answer" => "You can create a unique garden corner by combining plants of different heights, colors and shapes. Use pots and decorative tables to create a diverse and interesting space.",
    ],
    [
        "question" => "I want to give flowers to my loved ones on a special occasion. Do you have any suggestions on choosing the right plants and how to create impressive gifts?",
        "answer" => "This is great! You can choose bonsai that suits your loved one's taste and style. To create an impressive gift, you can include a handmade card and gift wrapping in a unique way.",
    ],
    [
        "question" => "I was looking for a way to combine cactus and succulents in an interior layout. Do you have any suggestions for this?",
        "answer" => "Of course, you can create a unique decorative composition by placing cacti and succulents on decorative stands or tables. Combine plants of different colors and shapes to create an interesting and eye-catching angle.        ",
    ],
    [
        "question" => "What measures are in place to ensure that my bonsai are not affected by environmental changes?",
        "answer" => "In order for bonsai to adapt well to environmental changes, you should gradually change the light conditions and watering frequency to let the plants adapt gradually. Check and adjust them slowly to avoid shocking the plant.",
    ],
    [
        "question" => "I'm interested in creating my own small indoor garden. Do you have any suggestions on choosing the right plants and how to arrange them?",
        "answer" => "Very good! You can choose from plants like cactus (cactus), succulents (stone lotus) and other small plants. For layout, you can use pots of different sizes and colors to create variety and creativity.",
    ],
    [
        "question" => "What is an Astro-type cactus and what makes it unique compared to other types of cactus?",
        "answer" => "Astro-type cactus is a unique variation of the cactus, with thick leaves and star-like shapes, creating an exotic and interesting look. What's unique about Astro is the combination of the unique shape of the leaves and the cactus's tolerance to smoke and dryness.",
    ],
    [
        "question" => "I would like to know what are the advantages of choosing non-flowering plants?",
        "answer" => "Non-flowering plants are usually easier to care for, don't require as much energy to maintain flowering, and the result is usually fresh green stems and leaves all year long.",
    ],
    [
        "question" => "Is there a way to make the plant without flowers more attractive from an aesthetic point of view?",
        "answer" => "You can create accents by choosing beautiful decorative pots, arranging plants to suit your green space, and even using a variety of foliage plants to create color and shape effects.",
    ],
    [
        "question" => "I am looking for a unique and meaningful gift. What kind of tree do you recommend?",
        "answer" => "If you are looking for a unique and meaningful gift, bonsai can be a great choice. Bonsai not only make the space more green but also bring freshness and tenderness. You can consider plants that are easy to grow and have good adaptability to the interior environment.",
    ],
    [
        "question" => "What kind of tree is meant to bring fortune?",
        "answer" => "Ficus racemosa carries many meanings in our spirituality and in our lives. The word has a complete and complete meaning, bringing a lot of fortune to the owner.",
    ],
    [
        "question" => "I want to buy flowers for Tet decoration, what kind of flowers should I choose?",
        "answer" => "You should choose Chrysanthemum morifolium or Anthurium Taiflower because the colors of these two plants are very suitable for the atmosphere of Tet.",
    ],
    [
        "question" => "I want to buy flowers with bright colors to plant in the garden",
        "answer" => "Abraham Rose is the perfect choice to make your garden more beautiful.        ",
    ],
    [
        "question" => "I want to buy a plant that can withstand bad weather",
        "answer" => "Skimmia japonica comes from the warm regions of Asia, but it is a favorite as a garden plant in the UK because it can cope with almost any weather. This is a rare plant that happily lives in deep shade and will provide a bit of color in winter. While it flowers in spring, it will be dotted with bright red (inedible) fruit from summer to winter.",
    ],
    [
        "question" => "I want to buy a suitable type of cactus for my desk",
        "answer" => "Rabbit ear cactus has the effect of absorbing computer radiation, so the tree is suitable for computer desks, desks ... In addition, the small, lovely tree used as a small gift for you is also very reasonable.",
    ],
    [
        "question" => "I want to buy a plant that can be used for beauty",
        "answer" => "Aloe vera is loved by many people for its decorative effect on living space along with its health and beauty benefits. This plant is also popular thanks to the feng shui meaning it brings to the homeowner.
        ",
    ],
    [
        "question" => "I want to buy a plant with a fancy shape",
        "answer" => "Haworthia Attenuate tree has a beautiful, fancy shape with long pointed leaves, green leaves alternating with white stripes. Plants help create a feeling of relaxation, comfort, and reduce stress and fatigue.",
    ],
    [
        "question" => "I want to find a hand guard for gardening",
        "answer" => "Then our gloves will help you protect your hands when gardening with a material of 60% latex and 40% polyester to ensure no harmful substances. For high durability and outstanding usability, manufactured on modern lines and technology.",
    ],
    [
        "question" => "I want to find a lawn mower",
        "answer" => "Our lawn shovel will make mowing the lawn easy and convenient.
        ",
    ],
    [
        "question" => "Xin chào",
        "answer" => "Xin chào, tôi có thể giúp gì cho bạn?.
        ",
    ],



    // Thêm các ví dụ khác tương tự ở đây
];

$matchedIndex = null;
$minDistance = PHP_INT_MAX;

foreach ($trainingData as $index => $data) {
    $distance = levenshtein(strtolower($userMessage), strtolower($data["question"]));
    if ($distance < $minDistance && $distance <= 10) {  // Adjust the distance threshold as needed
        $minDistance = $distance;
        $matchedIndex = $index;
    }
}

if ($matchedIndex !== null) {
    $aiResponse = $trainingData[$matchedIndex]["answer"];
}else {
    // Gửi yêu cầu đến OpenAI API để có câu trả lời
    $prompt = "Question: \"$userMessage\"\nAnswer: ";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/engines/davinci/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'prompt' => $prompt,
        'max_tokens' => 150,
        'temperature' => 0.6,  // Điều chỉnh nhiệt độ tạo ra câu trả lời
        'stop' => '\n',  // Dừng việc sinh câu trả lời khi gặp dấu xuống dòng
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $aiResponse = json_decode($response)->choices[0]->text;
}

echo json_encode(['message' => $aiResponse]);
