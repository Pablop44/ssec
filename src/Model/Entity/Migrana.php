<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Migrana Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $fecha
 * @property int $ficha
 * @property string $frecuencia
 * @property string $duracion
 * @property string $horario
 * @property string $finalizacion
 * @property string $tipoEpisodio
 * @property string $intensidad
 * @property string $limitaciones
 * @property string $despiertoNoche
 * @property string $estadoGeneral
 */
class Migrana extends Entity
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
        'frecuencia' => true,
        'duracion' => true,
        'horario' => true,
        'finalizacion' => true,
        'tipoEpisodio' => true,
        'intensidad' => true,
        'limitaciones' => true,
        'despiertoNoche' => true,
        'estadoGeneral' => true,
    ];
}
