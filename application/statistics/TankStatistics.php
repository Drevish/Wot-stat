<?php

require_once "Statistics.php";

class TankStatistics extends Statistics {

    // tank average statistics parameters
    private $tank_id;
    private $frags;
    private $damage;
    private $spot;
    private $defence;
    private $winrate;

    /**
     * TankStatistics constructor.
     * Creates a new TankStatistics object from data object
     * Data object requirements:
     * $data->tank_id                       - tank id
     * $data->all->battles                  - number of battles
     * $data->all->frags                    - frags total
     * $data->all->damage_dealt             - damage dealt total
     * $data->all->spotted                  - spotted total
     * $data->all->dropped_capture_points   - defence points total
     * $data->all->wins                     - wins total
     * @param $data json object
     */
    public function __construct($data)
    {
        $this->tank_id = $data->tank_id;

        $this->frags = floatval(number_format($data->all->frags / $data->all->battles, 10));

        $this->damage = floatval(number_format($data->all->damage_dealt / $data->all->battles, 10, '.', ''));

        $this->spot = floatval(number_format($data->all->spotted / $data->all->battles, 10));

        $this->defence = floatval(number_format($data->all->dropped_capture_points / $data->all->battles, 10));

        $this->winrate = floatval(number_format($data->all->wins / $data->all->battles * 100, 10));

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
        $tankExpectedValues = $expectedValues[$this->tank_id];


        // step 1
        $rDAMAGE = $this->damage    / $tankExpectedValues->expDamage;
        $rSPOT   = $this->spot      / $tankExpectedValues->expSpot;
        $rFRAG   = $this->frags     / $tankExpectedValues->expFrag;
        $rDEF    = $this->defence   / $tankExpectedValues->expDef;
        $rWIN    = $this->winrate   / $tankExpectedValues->expWinRate;


        // step 2;
        $rWINc    = max(0,                            ($rWIN    - 0.71) / (1 - 0.71) );
        $rDAMAGEc = max(0,                            ($rDAMAGE - 0.22) / (1 - 0.22) );
        $rFRAGc   = max(0, min($rDAMAGEc + 0.2, ($rFRAG   - 0.12) / (1 - 0.12)));
        $rSPOTc   = max(0, min($rDAMAGEc + 0.1, ($rSPOT   - 0.38) / (1 - 0.38)));
        $rDEFc    = max(0, min($rDAMAGEc + 0.1, ($rDEF    - 0.10) / (1 - 0.10)));

        $WN8 = 980*$rDAMAGEc + 210*$rDAMAGEc*$rFRAGc + 155*$rFRAGc*$rSPOTc + 75*$rDEFc*$rFRAGc + 145*min(1.8, $rWINc);

        return floor($WN8);
    }

    public function getWN8() {
        return $this->WN8;
    }
}