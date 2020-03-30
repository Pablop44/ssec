<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Diabetes Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $fecha
 * @property int $ficha
 * @property int $numeroControles
 * @property string $nivelBajo
 * @property string $frecuenciaBajo
 * @property string $horarioBajo
 * @property string $perdidaConocimiento
 * @property string $nivelAlto
 * @property string $frecuenciaAlto
 * @property string $horarioAlto
 * @property string $actividadFisica
 * @property string $problemaDieta
 * @property string $estadoGeneral
 */
class Diabetes extends Entity
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
        'numeroControles' => true,
        'nivelBajo' => true,
        'frecuenciaBajo' => true,
        'horarioBajo' => true,
        'perdidaConocimiento' => true,
        'nivelAlto' => true,
        'frecuenciaAlto' => true,
        'horarioAlto' => true,
        'actividadFisica' => true,
        'problemaDieta' => true,
        'estadoGeneral' => true,
    ];
}
