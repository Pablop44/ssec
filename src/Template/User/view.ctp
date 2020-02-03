<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="user view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($user->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Apellidos') ?></th>
            <td><?= h($user->apellidos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
            <td><?= h($user->telefono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Poblacion') ?></th>
            <td><?= h($user->poblacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cargo') ?></th>
            <td><?= h($user->cargo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Especialidad') ?></th>
            <td><?= h($user->especialidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cuenta') ?></th>
            <td><?= $this->Number->format($user->cuenta) ?></td>
        </tr>
    </table>
</div>
