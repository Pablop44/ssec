<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ficha Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $fechaCreacion
 * @property int $paciente
 * @property int $medico
 *
 * @property \App\Model\Entity\Enfermedad[] $enfermedad
 */
class Ficha extends Entity
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
        'fechaCreacion' => true,
        'paciente' => true,
        'medico' => true,
        'enfermedad' => true,
    ];
}
