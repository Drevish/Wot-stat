<?php

abstract class Statistics {
    protected $WN8;
    abstract public function calculateWN8();



    // table with color for every of 6 quality levels
    static private $colorsTable = ["#FE0E01", "#FF7D00", "#FDF109", "#5BFF00", "#00CAB3", "#D93DF9"];

    // minimum rating value to get ith quality level
    static private $WN8Table = [0, 448, 979, 1575, 2370, 3184];
    static private $WinrateTable = [0, 46.4, 49.2, 52.5, 57.8, 63.6];
    static private $WGTable = [0, 2709, 4676, 6784, 9049, 10497];

    static private function getColorByQualityLevel($level) {
           return self::$colorsTable[$level];
    }

    static private function getQualityLevelByTable($table, $value) {
        foreach ($table as $key => $item) {
            if ($value < $item) return ($key - 1);
        }

        return (count($table) - 1);
    }

    static public function getColorByWN8($value) {
        return self::getColorByQualityLevel(self::getQualityLevelByTable(self::$WN8Table, $value));
    }

    static public function getColorByWinrate($value) {
        return self::getColorByQualityLevel(self::getQualityLevelByTable(self::$WinrateTable, $value));
    }

    static public function getColorByWG($value) {
        return self::getColorByQualityLevel(self::getQualityLevelByTable(self::$WGTable, $value));
    }
}