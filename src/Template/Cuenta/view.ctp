<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuentum $cuentum
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cuentum'), ['action' => 'edit', $cuentum->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cuentum'), ['action' => 'delete', $cuentum->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cuentum->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cuenta'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cuentum'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cuenta view large-9 medium-8 columns content">
    <h3><?= h($cuentum->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Rol') ?></th>
            <td><?= h($cuentum->rol) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= h($cuentum->estado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cuentum->id) ?></td>
        </tr>
    </table>
</div>
