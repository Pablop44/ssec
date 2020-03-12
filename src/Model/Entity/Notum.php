<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notum Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $fecha
 * @property string $datos
 * @property int $ficha
 */
class Notum extends Entity
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
        'id' => true,
        'fecha' => true,
        'datos' => true,
        'ficha' => true,
    ];
}
