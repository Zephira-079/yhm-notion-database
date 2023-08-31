<?php

class Notion {
    private $auth_token;
    private $headers;

    public function __construct($auth_token) {
        $this->auth_token = $auth_token;
        $this->headers = array(
            'Authorization: Bearer ' . $auth_token,
            'Content-Type: application/json',
            'Notion-Version: 2022-02-22'
        );
    }

    public function database($database_id) {
        return new Database($database_id, $this->headers);
    }
}

class Database {
    private $database_id;
    private $headers;
    private $table_page_url;
    private $table_page_read_url;

    public function __construct($database_id, $headers) {
        $this->database_id = $database_id;
        $this->headers = $headers;
        $this->table_page_url = 'https://api.notion.com/v1/pages';
        $this->table_page_read_url = "https://api.notion.com/v1/databases/$database_id/query";
    }

    public function get_raw() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->table_page_read_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, "./cacert.pem");
        curl_setopt($ch, CURLOPT_POST, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function create_row(...$properties) {
        $row_data = array(
            "parent" => array("database_id" => $this->database_id),
            "properties" => array()
        );

        foreach ($properties as $property) {
            $key = array_keys($property)[0];
            $row_data["properties"][$key] = $property[$key];
        }

        $data = json_encode($row_data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->table_page_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CAINFO, "./cacert.pem");
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_code;
    }

    public function update_row($page_id, ...$properties) {
        $row_data = array(
            "parent" => array("database_id" => $this->database_id),
            "properties" => array()
        );

        foreach ($properties as $property) {
            $key = array_keys($property)[0];
            $row_data["properties"][$key] = $property[$key];
        }

        $data = json_encode($row_data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->table_page_url . '/' . $page_id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CAINFO, "./cacert.pem"); 
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_code;
    }

    public function delete_row($page_id) {
        $row_data = array(
            "parent" => array("database_id" => $this->database_id),
            "archived" => true
        );

        $data = json_encode($row_data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->table_page_url . '/' . $page_id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CAINFO, "./cacert.pem"); 
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_code;
    }
}

?>
