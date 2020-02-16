<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Consultum Entity
 *
 * @property int $id
 * @property string $lugar
 * @property string $motivo
 * @property \Cake\I18n\FrozenDate $fecha
 * @property string|null $diagnostico
 * @property string|null $observaciones
 * @property int $medico
 * @property int $paciente
 * @property int $ficha
 * @property string $estado
 */
class Consultum extends Entity
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
        'lugar' => true,
        'motivo' => true,
        'fecha' => true,
        'diagnostico' => true,
        'observaciones' => true,
        'medico' => true,
        'paciente' => true,
        'ficha' => true,
        'estado' => true,
    ];
}
