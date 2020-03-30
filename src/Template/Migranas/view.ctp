<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Migrana $migrana
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Migrana'), ['action' => 'edit', $migrana->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Migrana'), ['action' => 'delete', $migrana->id], ['confirm' => __('Are you sure you want to delete # {0}?', $migrana->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Migranas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Migrana'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="migranas view large-9 medium-8 columns content">
    <h3><?= h($migrana->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Frecuencia') ?></th>
            <td><?= h($migrana->frecuencia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Duracion') ?></th>
            <td><?= h($migrana->duracion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Horario') ?></th>
            <td><?= h($migrana->horario) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finalizacion') ?></th>
            <td><?= h($migrana->finalizacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('TipoEpisodio') ?></th>
            <td><?= h($migrana->tipoEpisodio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Intensidad') ?></th>
            <td><?= h($migrana->intensidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Limitaciones') ?></th>
            <td><?= h($migrana->limitaciones) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DespiertoNoche') ?></th>
            <td><?= h($migrana->despiertoNoche) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('EstadoGeneral') ?></th>
            <td><?= h($migrana->estadoGeneral) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($migrana->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($migrana->ficha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($migrana->fecha) ?></td>
        </tr>
    </table>
</div>
