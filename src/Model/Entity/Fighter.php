<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Fighter Entity
 *
 * @property int $id
 * @property string $name
 * @property string $player_id
 * @property int $coordinate_x
 * @property int $coordinate_y
 * @property int $level
 * @property int $xp
 * @property int $skill_sight
 * @property int $skill_strength
 * @property int $skill_health
 * @property int $current_health
 * @property \Cake\I18n\FrozenTime $next_action_time
 * @property int $guild_id
 */
class Fighter extends Entity
{


    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'player_id' => true,
        'coordinate_x' => true,
        'coordinate_y' => true,
        'level' => true,
        'xp' => true,
        'skill_sight' => true,
        'skill_strength' => true,
        'skill_health' => true,
        'current_health' => true,
        'next_action_time' => true,
        'guild_id' => true
    ];
}
