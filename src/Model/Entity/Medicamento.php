<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Medicamento Entity
 *
 * @property string $nombre
 * @property string $viaAdministracion
 * @property string $marca
 * @property string $dosis
 *
 * @property \App\Model\Entity\Tratamiento[] $tratamiento
 */
class Medicamento extends Entity
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
        'nombre' => true,
        'viaAdministracion' => true,
        'marca' => true,
        'dosis' => true,
        'tratamiento' => true,
    ];
}
