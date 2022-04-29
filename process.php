<?php
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['name']) && !empty($data['name'])) {
    if (isset($data['firstName']) && !empty($data['firstName'])) {
        if (isset($data['mail']) && !empty($data['mail'])) {
            if (isset($data['society']) && !empty($data['society'])) {
                if (isset($data['message']) && !empty($data['message'])) {
                    $data_ok = ["status" => "200"];
                    echo json_encode($data_ok);
//                    Générer un email à envoyer, si succes retourner code 200 sinon retourner code 500 avec l'erreur.
                } else {
                    $data_error = ["status" => "500", "field" => 'message'];
                    echo json_encode($data_error);
                }
            } else {
                $data_error = ["status" => "500", "field" => 'society'];
                echo json_encode($data_error);
            }
        } else {
            $data_error = ["status" => "500", "field" => 'mail'];
            echo json_encode($data_error);
        }
    } else {
        $data_error = ["status" => "500", "field" => 'firstName'];
        echo json_encode($data_error);
    }
} else {
    $data_error = ["status" => "500", "field" => 'name'];
    echo json_encode($data_error);
}