<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asma $asma
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Asma'), ['action' => 'edit', $asma->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Asma'), ['action' => 'delete', $asma->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asma->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Asma'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Asma'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="asma view large-9 medium-8 columns content">
    <h3><?= h($asma->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('CalidadSueno') ?></th>
            <td><?= h($asma->calidadSueno) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DificultadRespirar') ?></th>
            <td><?= h($asma->dificultadRespirar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tos') ?></th>
            <td><?= h($asma->tos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('GravedadTos') ?></th>
            <td><?= h($asma->gravedadTos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Limitaciones') ?></th>
            <td><?= h($asma->limitaciones) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Silbidos') ?></th>
            <td><?= h($asma->silbidos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('UsoMedicacion') ?></th>
            <td><?= h($asma->usoMedicacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Espirometria') ?></th>
            <td><?= h($asma->espirometria) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('FactoresCrisis') ?></th>
            <td><?= h($asma->factoresCrisis) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('EstadoGeneral') ?></th>
            <td><?= h($asma->estadoGeneral) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($asma->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($asma->ficha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($asma->fecha) ?></td>
        </tr>
    </table>
</div>
