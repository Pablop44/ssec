<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consultum $consultum
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Consultum'), ['action' => 'edit', $consultum->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Consultum'), ['action' => 'delete', $consultum->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consultum->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Consulta'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Consultum'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="consulta view large-9 medium-8 columns content">
    <h3><?= h($consultum->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lugar') ?></th>
            <td><?= h($consultum->lugar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Motivo') ?></th>
            <td><?= h($consultum->motivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Diagnostico') ?></th>
            <td><?= h($consultum->diagnostico) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Observaciones') ?></th>
            <td><?= h($consultum->observaciones) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= h($consultum->estado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($consultum->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Medico') ?></th>
            <td><?= $this->Number->format($consultum->medico) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Paciente') ?></th>
            <td><?= $this->Number->format($consultum->paciente) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($consultum->ficha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($consultum->fecha) ?></td>
        </tr>
    </table>
</div>
