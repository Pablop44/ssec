<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Asma Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $fecha
 * @property int $ficha
 * @property string $calidadSueno
 * @property string $dificultadRespirar
 * @property string $tos
 * @property string $gravedadTos
 * @property string $limitaciones
 * @property string $silbidos
 * @property string $usoMedicacion
 * @property string $espirometria
 * @property string $factoresCrisis
 * @property string $estadoGeneral
 */
class Asma extends Entity
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
        'fecha' => true,
        'ficha' => true,
        'calidadSueno' => true,
        'dificultadRespirar' => true,
        'tos' => true,
        'gravedadTos' => true,
        'limitaciones' => true,
        'silbidos' => true,
        'usoMedicacion' => true,
        'espirometria' => true,
        'factoresCrisis' => true,
        'estadoGeneral' => true,
    ];
}
