<?php
class Properties {
    public function title($column_name, ...$labels) {
        return [
            $column_name => [
                "title" => array_map(function ($label) {
                    return ["text" => ["content" => $label]];
                }, $labels)
            ]
        ];
    }

    public function text($column_name, ...$contents) {
        return [
            $column_name => [
                "rich_text" => array_map(function ($content) {
                    return ["text" => ["content" => $content]];
                }, $contents)
            ]
        ];
    }

    public function checkbox($column_name, $boolean) {
        return [
            $column_name => [
                "checkbox" => $boolean
            ]
        ];
    }

    public function number($column_name) {
        return [
            $column_name => [
                "number" => 1999
            ]
        ];
    }

    public function select($column_name, $label) {
        return [
            $column_name => [
                "select" => [
                    "name" => $label
                ]
            ]
        ];
    }

    public function multi_select($column_name, ...$labels) {
        return [
            $column_name => [
                "multi_select" => array_map(function ($label) {
                    return ["name" => $label];
                }, $labels)
            ]
        ];
    }

    public function date($column_name, $start, $end) {
        return [
            $column_name => [
                "date" => [
                    "start" => "2022-08-05",
                    "end" => "2022-08-10"
                ]
            ]
        ];
    }

    public function url($column_name, $url_address) {
        return [
            $column_name => [
                "url" => $url_address
            ]
        ];
    }

    public function email($column_name, $email_address) {
        return [
            $column_name => [
                "email" => $email_address
            ]
        ];
    }

    public function phone($column_name, $phone_number) {
        return [
            $column_name => [
                "phone_number" => $phone_number
            ]
        ];
    }

    public function people($column_name) {
        return [
            $column_name => [
                "people" => [
                    [
                        "id" => "4af42d2d-a077-4808-b4f7-e960a93fd945"
                    ]
                ]
            ]
        ];
    }

    public function relation($column_name) {
        return [
            $column_name => [
                "relation" => [
                    [
                        "id" => "fbb0a7f2-413e-4728-adbf-281ab14f0c33"
                    ]
                ]
            ]
        ];
    }

    public function column($database_raw, $column_name) {
        $values = [];
        $database = $database_raw["results"];
    
        foreach ($database as $row_raw) {
            $row_content = $row_raw["properties"][$column_name];
    
            if (isset($row_content["title"])) {
                $title_values = [];
                foreach ($row_content["title"] as $content) {
                    $title_values[] = isset($content["text"]["content"]) ? $content["text"]["content"] : null;
                }
                $values[] = $title_values;
            }
    
            if (isset($row_content["rich_text"])) {
                $rich_text_values = [];
                foreach ($row_content["rich_text"] as $content) {
                    $rich_text_values[] = isset($content["text"]["content"]) ? $content["text"]["content"] : null;
                }
                $values[] = $rich_text_values;
            }
    
            if (isset($row_content["checkbox"])) {
                $values[] = isset($row_content["checkbox"]) ? $row_content["checkbox"] : null;
            }
    
            if (isset($row_content["number"])) {
                $values[] = isset($row_content["number"]) ? $row_content["number"] : null;
            }
    
            if (isset($row_content["select"])) {
                try {
                    $values[] = isset($row_content["select"]["name"]) ? $row_content["select"]["name"] : null;
                } catch (Exception $e) {
                    $values[] = "";
                }
            }
    
            if (isset($row_content["multi_select"])) {
                $multi_select_values = [];
                foreach ($row_content["multi_select"] as $content) {
                    $multi_select_values[] = isset($content["name"]) ? $content["name"] : null;
                }
                $values[] = $multi_select_values;
            }
    
            if (isset($row_content["date"])) {
                $date_start = isset($row_content["date"]["start"]) ? $row_content["date"]["start"] : null;
                $date_end = isset($row_content["date"]["end"]) ? $row_content["date"]["end"] : null;
                $values[] = [$date_start, $date_end];
            }
    
            if (isset($row_content["url"])) {
                $values[] = isset($row_content["url"]) ? $row_content["url"] : null;
            }
    
            if (isset($row_content["email"])) {
                $values[] = isset($row_content["email"]) ? $row_content["email"] : null;
            }
    
            if (isset($row_content["phone_number"])) {
                $values[] = isset($row_content["phone_number"]) ? $row_content["phone_number"] : null;
            }
    
            if (isset($row_content["people"])) {
                $people_values = [];
                foreach ($row_content["people"] as $content) {
                    $people_values[] = isset($content["id"]) ? $content["id"] : null;
                }
                $values[] = $people_values;
            }
    
            if (isset($row_content["relation"])) {
                $relation_values = [];
                foreach ($row_content["relation"] as $content) {
                    $relation_values[] = isset($content["id"]) ? $content["id"] : null;
                }
                $values[] = $relation_values;
            }
        }
    
        return $values;
    }
    

    public function has($database_raw, $column_name, ...$matches) {
        $ids = [];
        $database = $database_raw["results"];
    
        foreach ($database as $row_raw) {
            $row_content = $row_raw["properties"][$column_name];
            $row_id = $row_raw["id"];
    
            if (isset($row_content["title"])) {
                if (array_reduce($row_content["title"], function($carry, $content) use ($matches) {
                    return $carry || (isset($content["text"]["content"]) && in_array($content["text"]["content"], $matches));
                }, false)) {
                    $ids[] = $row_id;
                }
            }
    
            if (isset($row_content["rich_text"])) {
                if (array_reduce($row_content["rich_text"], function($carry, $content) use ($matches) {
                    return $carry || (isset($content["text"]["content"]) && in_array($content["text"]["content"], $matches));
                }, false)) {
                    $ids[] = $row_id;
                }
            }
    
            if (isset($row_content["checkbox"]) && in_array($row_content["checkbox"], $matches)) {
                $ids[] = $row_id;
            }
    
            if (isset($row_content["number"]) && in_array($row_content["number"], $matches)) {
                $ids[] = $row_id;
            }
    
            if (isset($row_content["select"]) && isset($row_content["select"]["name"]) && in_array($row_content["select"]["name"], $matches)) {
                $ids[] = $row_id;
            }
    
            if (isset($row_content["multi_select"])) {
                if (array_reduce($row_content["multi_select"], function($carry, $content) use ($matches) {
                    return $carry || (isset($content["name"]) && in_array($content["name"], $matches));
                }, false)) {
                    $ids[] = $row_id;
                }
            }
    
            if (isset($row_content["date"])) {
                $start = isset($row_content["date"]["start"]) ? $row_content["date"]["start"] : null;
                $end = isset($row_content["date"]["end"]) ? $row_content["date"]["end"] : null;
                if (in_array($start, $matches) || in_array($end, $matches)) {
                    $ids[] = $row_id;
                }
            }
    
            if (isset($row_content["url"]) && in_array($row_content["url"], $matches)) {
                $ids[] = $row_id;
            }
    
            if (isset($row_content["email"]) && in_array($row_content["email"], $matches)) {
                $ids[] = $row_id;
            }
    
            if (isset($row_content["phone_number"]) && in_array($row_content["phone_number"], $matches)) {
                $ids[] = $row_id;
            }
    
            if (isset($row_content["people"])) {
                if (array_reduce($row_content["people"], function($carry, $content) use ($matches) {
                    return $carry || (isset($content["id"]) && in_array($content["id"], $matches));
                }, false)) {
                    $ids[] = $row_id;
                }
            }
    
            if (isset($row_content["relation"])) {
                if (array_reduce($row_content["relation"], function($carry, $content) use ($matches) {
                    return $carry || (isset($content["id"]) && in_array($content["id"], $matches));
                }, false)) {
                    $ids[] = $row_id;
                }
            }
        }
    
        return $ids;
    }
    
}

?>