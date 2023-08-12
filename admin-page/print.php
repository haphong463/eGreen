<?php
require_once '../db/dbhelper.php';
require_once 'tcpdf/tcpdf.php';

if ($_GET['order_id']) {
    $order_id = $_GET['order_id'];
    $order_query = "SELECT * FROM order_details WHERE order_id = '$order_id'";
    $order_result = executeResult($order_query);

    if (!empty($order_result)) {
        foreach ($order_result as $order) {
            $product_id =  $order['plant_id'];
        }

        // Retrieve product information from the "product" table based on the product ID
        $product_query = "SELECT plant_id, category_id, name, price FROM plants WHERE plant_id = $product_id";
        $product_result = executeResult($product_query);
    }

    // Retrieve other necessary information for the order
    $sql4 = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $total = executeSingleResult($sql4);
    $order_date = $total['order_date'];

    $sql = "SELECT user_id FROM orders WHERE order_id = '$order_id'";
    $result = executeSingleResult($sql);

    $c_id = $result['user_id'];


    $sql2 = "SELECT * FROM users WHERE user_id = $c_id";
    $users = executeSingleResult($sql2);




    $cancel_order_query = "SELECT * FROM cancel_order WHERE order_id = '$order_id'";
    $cancel_order_result = executeSingleResult($cancel_order_query);

    if ($cancel_order_result != NULL) {
        $reason = $cancel_order_result['reason'];
        switch ($reason) {
            case "out_of_stock":
                $reason = "Item is out of stock";
                break;
            case "decision":
                $reason = "Changed my purchase decision";
                break;
            case "changed_mind":
                $reason = "Changed my mind";
                break;
            case "other":
                $reason = "Other reason";
                break;
        }
    }
}

// Create a new PDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator('PlantNest');
$pdf->SetAuthor('PlantNest');
$pdf->SetTitle('Invoice PDF | Order #' . $order_id . '');
$pdf->SetSubject('Order Details');
$pdf->SetKeywords('order, details, product');

// Set default header data
$pdf->SetHeaderData('', 0, 'Invoice', 'PlantNest');

// Set default header font
$pdf->setHeaderFont(array('helvetica', 'B', 14));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// Set margins
$pdf->SetMargins(15, 15, 15);

// Set auto page breaks
$pdf->SetAutoPageBreak(true, 30);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// Generate content
$content = '';
$content .= '<p><b>Order #' . $order_id . '</b></p>';
$content .= '<p>' . $order_date . '</p>';

$content .= '<h4>Order Details</h4>';
$content .= '<table border="1">';
$content .= '<thead><tr><th>Information</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr></thead>';
$content .= '<tbody>';

$subtotal = 0; // Initialize subtotal

foreach ($order_result as $order_details) {
    $pid = $order_details['plant_id'];
    $quantity = $order_details['quantity'];

    $product_query = "SELECT plant_id, category_id, name, price FROM plants WHERE plant_id = $pid";
    $product_result = executeSingleResult($product_query);

    $total_amount = $total['total_amount'];

    $cat_id = $product_result['category_id'];

    $category_query = "SELECT * FROM categories WHERE category_id = $cat_id";
    $category_result = executeSingleResult($category_query);

    $total_amount_item = $quantity * $order_details['price'];

    $subtotal += $total_amount_item;

    $content .= '<tr>';
    $content .= '<td>';
    $content .= '<b>' . $product_result['name'] . '</b>';
    $content .= '<br>Category: ' . $category_result['name'];
    $content .= '<br>Description: ' . $product_result['description'];

    $content .= '</td>';
    $content .= '<td>$' . number_format($order_details['price'], 2, '.') . '</td>';
    $content .= '<td>' . $quantity . '</td>';
    $content .= '<td>$' . number_format($total_amount_item, 2, '.') . '</td>';
    $content .= '</tr>';
}

$content .= '</tbody>';
$content .= '<tfoot>';
$content .= '<tr><td colspan="3"><b>Sub Total:</b></td><td>$' . number_format($subtotal, 2, '.') . '</td></tr>';

if (isset($coupon)) {
    $content .= '<tr><td colspan="3"><b>Discount (Code: ' . $coupon['coupon_code'] . '):</b></td><td>' . number_format($discount_amount, 2, '.') . '%</td></tr>';
}

$content .= '<tr><td colspan="3"><b>Shipping Fee:</b></td><td>$' . number_format($total['shipping_fee'], 2, '.') . '</td></tr>';
$content .= '<tr><td colspan="3"><b>Total:</b></td><td><b>$' . number_format($total_amount, 2, '.') . '</b></td></tr>';
$content .= '</tfoot>';
$content .= '</table>';

$content .= '<h4>Shipping Information</h4>';
$content .= '<p>Customer: ' . $users['fullname'] . '</p>';
$content .= '<p>Email: ' . $users['email'] . '</p>';
$content .= '<p>Contact: ' . $users['phone'] . '</p>';
$content .= '<p>Shipping address: ' . $users['address'] . '</p>';

// Write content to PDF
// Write content to PDF
$pdf->writeHTML($content, true, false, true, false, '');

// Get the PDF content as a string
$pdfData = $pdf->Output('', 'S');

// Set headers for previewing the PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="order_details_' . $order_id . '.pdf"');

// Output the PDF content
echo $pdfData;
