<?php

namespace Controllers;

use Core\App;
use Core\Database;

class WandController
{
    public static function createRandomWand()
    {
        $db = App::resolve(Database::class);

        $woods = ['Holly', 'Yew', 'Elder', 'Willow', 'Hawthorn', 'Oak'];
        $cores = ['Phoenix Feather', 'Dragon Heartstring', 'Unicorn Hair', 'Thestral Tail Hair'];

        $wood = $woods[array_rand($woods)];
        $core = $cores[array_rand($cores)];

        $db->query("
            INSERT INTO wands (wood_type, core_type)
            VALUES (:wood, :core)
        ", [
            ':wood' => $wood,
            ':core' => $core
        ]);

        return $db->query("SELECT * FROM wands ORDER BY id DESC LIMIT 1")->find();
    }
}