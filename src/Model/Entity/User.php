<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $dni
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $nombre
 * @property string $apellidos
 * @property string $telefono
 * @property string $poblacion
 * @property int|null $colegiado
 * @property string|null $cargo
 * @property string|null $especialidad
 * @property string|null $genero
 * @property \Cake\I18n\FrozenTime|null $nacimiento
 */
class User extends Entity
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
        'dni' => true,
        'username' => true,
        'password' => true,
        'email' => true,
        'nombre' => true,
        'apellidos' => true,
        'telefono' => true,
        'poblacion' => true,
        'colegiado' => true,
        'cargo' => true,
        'especialidad' => true,
        'genero' => true,
        'nacimiento' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
          return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
