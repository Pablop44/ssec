<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tratamiento Entity
 *
 * @property int $id
 * @property string $posologia
 * @property \Cake\I18n\FrozenDate $fechaInicio
 * @property \Cake\I18n\FrozenDate $fechaFin
 * @property \Cake\I18n\FrozenTime $horario
 * @property string $enfermedad
 * @property int $ficha
 *
 * @property \App\Model\Entity\Medicamento[] $medicamento
 */
class Tratamiento extends Entity
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
        'posologia' => true,
        'fechaInicio' => true,
        'fechaFin' => true,
        'horario' => true,
        'enfermedad' => true,
        'ficha' => true,
        'medicamento' => true,
    ];
}
