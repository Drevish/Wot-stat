<?php

require_once "Statistics.php";

class UserStatistics extends Statistics {

    /*  array of objects that represent tank statistics
        parameters:
        tank_id         - tank id
        frags           - tank average frags number
        damage          - tank average damage per battle
        spot            - tank average spot number
        defence         - tank average dropped capture points per battle
        winrate         - tank winrate
        battles         - tank battles number
    */
    private $tanks;

    /**
     * UserStatistics constructor.
     * Creates a new UserStatistics object from data object
     * Data object requirements:
     * $data[i]->tank_id                       - tank id
     * $data[i]->all->battles                  - number of battles
     * $data[i]->all->frags                    - frags total
     * $data[i]->all->damage_dealt             - damage dealt total
     * $data[i]->all->spotted                  - spotted total
     * $data[i]->all->dropped_capture_points   - defence points total
     * $data[i]->all->wins                     - wins total
     * @param $data json object
     */
    public function __construct($data)
    {

        foreach ($data as $tank) {
            $this->tanks[] = [
                "tank_id"   => $tank->tank_id,

                "frags"     => floatval(number_format($tank->all->frags / $tank->all->battles, 10)),

                "damage"    => floatval(number_format($tank->all->damage_dealt / $tank->all->battles, 10, '.', '')),

                "spot"      => floatval(number_format($tank->all->spotted / $tank->all->battles, 10)),

                "defence"   => floatval(number_format($tank->all->dropped_capture_points / $tank->all->battles, 10)),

                "winrate"   => floatval(number_format($tank->all->wins / $tank->all->battles * 100, 10)),

                "battles"   => floatval(number_format($tank->all->battles, 10, '.', ''))
            ];
        }

        // calculate ratings
        $this->WN8 = $this->calculateWN8();
    }


    /**
     * @return float|int
     */
    public function getTankId()
    {
        return $this->tank_id;
    }

    /**
     * @return float|int
     */
    public function getFrags()
    {
        return $this->frags;
    }

    /**
     * @return float|int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * @return float|int
     */
    public function getSpot()
    {
        return $this->spot;
    }

    /**
     * @return float|int
     */
    public function getDefence()
    {
        return $this->defence;
    }

    /**
     * @return float|int
     */
    public function getWinrate()
    {
        return $this->winrate;
    }


    private function getExpectedValues() {
        // expected tank values in php serialization format
        $filename = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."expected_tank_values.dat";

        $file = fopen( $filename, 'r');
        $expected_tank_values = fread($file, filesize($filename));

        return unserialize($expected_tank_values);
    }

    /**
     * Calculates WN8 rating using this tank statistics and expected values
     * @return float
     */
    public function calculateWN8()
    {
        $expectedValues = $this->getExpectedValues();

        $totalDamage = 0;
        $totalSpot = 0;
        $totalFrags = 0;
        $totalDefence = 0;
        $totalWins = 0;

        $expectedDamage = 0;
        $expectedSpot = 0;
        $expectedFrags = 0;
        $expectedDefence = 0;
        $expectedWins = 0;

        foreach ($this->tanks as $tank) {

            $totalDamage += $tank["damage"] * $tank["battles"];
            $totalSpot += $tank["spot"] * $tank["battles"];
            $totalFrags += $tank["frags"] * $tank["battles"];
            $totalDefence += $tank["defence"] * $tank["battles"];
            $totalWins += ($tank["winrate"] / 100) * $tank["battles"];


            $tankExpectedValues = $expectedValues[$tank["tank_id"]];

            $expectedDamage += $tankExpectedValues->expDamage * $tank["battles"];
            $expectedSpot += $tankExpectedValues->expSpot * $tank["battles"];
            $expectedFrags += $tankExpectedValues->expFrag * $tank["battles"];
            $expectedDefence += $tankExpectedValues->expDef * $tank["battles"];
            $expectedWins += ($tankExpectedValues->expWinRate / 100) * $tank["battles"];
        }


        // step 1
        $rDAMAGE = $totalDamage / $expectedDamage;
        $rSPOT = $totalSpot / $expectedSpot;
        $rFRAG = $totalFrags / $expectedFrags;
        $rDEF = $totalDefence / $expectedDefence;
        $rWIN = $totalWins / $expectedWins;


        // step 2;
        $rWINc    = max(0,                            ($rWIN    - 0.71) / (1 - 0.71) );
        $rDAMAGEc = max(0,                            ($rDAMAGE - 0.22) / (1 - 0.22) );
        $rFRAGc   = max(0, min($rDAMAGEc + 0.2, ($rFRAG   - 0.12) / (1 - 0.12)));
        $rSPOTc   = max(0, min($rDAMAGEc + 0.1, ($rSPOT   - 0.38) / (1 - 0.38)));
        $rDEFc    = max(0, min($rDAMAGEc + 0.1, ($rDEF    - 0.10) / (1 - 0.10)));

        $WN8 = 980*$rDAMAGEc + 210*$rDAMAGEc*$rFRAGc + 155*$rFRAGc*$rSPOTc + 75*$rDEFc*$rFRAGc + 145*min(1.8, $rWINc);

        if ($WN8 == null || is_nan($WN8)) $WN8 = 0;
        return floor($WN8);
    }

    public function getWN8() {
        return $this->WN8;
    }
}