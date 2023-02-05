<?php

namespace App\Services;

class HelperServices
{

    public function randomColor($total): array
    {
        $colors = [
            "#1abc9c",
            "#2ecc71",
            "#3498db",
            "#9b59b6",
            "#f1c40f",
            "#e67e22",
            "#e74c3c",
            "#16a085",
            "#27ae60",
            "#2980b9",
            "#8e44ad",
            "#f39c12",
            "#d35400",
            "#c0392b",
        ];

        $result = [];
        for ($i = 0; $i < $total; $i++) {
            $result[] = $colors[$i % count($colors)];
        }

        return $result;
    }
}
